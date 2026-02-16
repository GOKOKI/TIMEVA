<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Afficher la page de paiement
     */
    public function index()
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')
                            ->with('error', 'Veuillez vous connecter pour finaliser votre commande');
        }

        // Récupérer le panier
        $panier = Panier::with('variante.produit')
                       ->where('user_id', Auth::id())
                       ->get();

        if ($panier->isEmpty()) {
            return redirect()->route('cart.index')
                            ->with('error', 'Votre panier est vide');
        }

        // Vérifier le stock
        foreach ($panier as $article) {
            if ($article->quantite > $article->variante->quantite_stock) {
                return redirect()->route('cart.index')
                                ->with('error', 'Stock insuffisant pour ' . $article->variante->produit->nom);
            }
        }

        // Récupérer le profil
        $profil = Auth::user()->profil;

        if (!$profil) {
            return redirect()->route('profile.edit')
                            ->with('warning', 'Veuillez compléter votre profil avant de commander');
        }

        $total = $panier->sum(function ($item) {
            return $item->variante->prix_final * $item->quantite;
        });

        return view('checkout.index', compact('panier', 'profil', 'total'));
    }

    /**
     * Traiter le paiement
     */
    public function process(Request $request)
    {
        $request->validate([
            'adresse_livraison' => 'required|string',
            'code_postal' => 'required|string',
            'ville' => 'required|string',
            'pays' => 'required|string',
            'mode_paiement' => 'required|in:carte,paypal'
        ]);

        try {
            DB::beginTransaction();

            $panier = Panier::with('variante.produit')
                           ->where('user_id', Auth::id())
                           ->get();

            if ($panier->isEmpty()) {
                throw new \Exception('Panier vide');
            }

            $total = $panier->sum(function ($item) {
                return $item->variante->prix_final * $item->quantite;
            });

            // Créer la commande
            $commande = Commande::create([
                'id' => Str::uuid(),
                'user_id' => Auth::id(),
                'statut' => 'en attente',
                'montant' => $total,
                'adresse_livraison' => $request->adresse_livraison,
                'code_postal' => $request->code_postal,
                'ville' => $request->ville,
                'pays_expedition' => $request->pays,
                'date_creation' => now(),
                'date_modification' => now()
            ]);

            // Ici tu ajouterais la logique de paiement (Stripe, PayPal...)

            DB::commit();

            return redirect()->route('checkout.success', $commande->id)
                            ->with('success', 'Commande validée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la commande: ' . $e->getMessage());
        }
    }

    /**
     * Page de succès
     */
    public function success($commandeId)
    {
        $commande = Commande::with('articles')
                           ->where('user_id', Auth::id())
                           ->findOrFail($commandeId);

        return view('checkout.success', compact('commande'));
    }

    /**
     * Annulation de paiement
     */
    public function cancel()
    {
        return redirect()->route('cart.index')
                        ->with('info', 'Paiement annulé');
    }
}