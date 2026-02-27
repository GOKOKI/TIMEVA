<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Commande;
use App\Models\CommandeArticle;
use App\Notifications\OrderPlaced;

class CheckoutController extends Controller
{
    /**
     * Afficher la page de checkout avec le récap du panier
     */
    public function index()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('cart.checkout', compact('cart', 'total'));
    }

    /**
     * Traiter la commande : valider, enregistrer, notifier, vider le panier
     */
    public function process(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $validated = $request->validate([
            'adresse_livraison' => 'required|string|max:255',
            'code_postal'       => 'required|string|max:10',
            'pays_expedition'   => 'required|string|max:100',
        ]);

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Créer la commande
        $commande = Commande::create([
            'user_id'           => Auth::id(),
            'reference'         => 'CMD-' . strtoupper(Str::random(8)),
            'montant'           => $total,
            'statut'            => 'en_attente',
            'adresse_livraison' => $validated['adresse_livraison'],
            'code_postal'       => $validated['code_postal'],
            'pays_expedition'   => $validated['pays_expedition'],
        ]);

        // Créer les articles de la commande
        foreach ($cart as $item) {
            CommandeArticle::create([
                'commande_id'    => $commande->id,
                'nom_produit'    => $item['name'],
                'infos_variante' => [
                    'couleur' => $item['variant_name'] ?? null,
                ],
                'quantite'       => $item['quantity'],
                'prix_unitaire'  => $item['price'],
                'total'          => $item['price'] * $item['quantity'],
            ]);
        }

        // Vider le panier
        Session::forget('cart');

        // Envoyer la notification email de confirmation
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->notify(new OrderPlaced($commande));

        return redirect()->route('checkout.success', $commande->id);
    }

    /**
     * Afficher la page de confirmation de commande
     */
    public function success(Commande $commande)
    {
        $commande->load('articles');

        return view('checkout.success', compact('commande'));
    }

    /**
     * Afficher la page d'annulation
     */
    public function cancel()
    {
        return view('checkout.cancel');
    }
}
