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
     * Créer la commande et rediriger vers FedaPay
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

        // Créer la commande (statut non_paye en attente de confirmation FedaPay)
        $commande = Commande::create([
            'user_id'           => Auth::id(),
            'reference'         => 'CMD-' . strtoupper(Str::random(8)),
            'montant'           => $total,
            'statut'            => 'en_attente',
            'paiement_statut'   => 'non_paye',
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

        // Initier le paiement FedaPay
        try {
            \FedaPay\FedaPay::setApiKey(config('services.fedapay.secret_key'));
            \FedaPay\FedaPay::setEnvironment(config('services.fedapay.environment', 'sandbox'));

            /** @var \App\Models\User $user */
            $user = Auth::user();

            $transaction = \FedaPay\Transaction::create([
                'description' => 'Commande TIMEVA ' . $commande->reference,
                'amount'      => (int) round($commande->montant),
                'currency'    => ['iso' => 'XOF'],
                'callback_url' => route('checkout.fedapay.callback', $commande->id),
                'customer'    => [
                    'firstname' => $user->prenom ?? $user->nom,
                    'lastname'  => $user->nom,
                    'email'     => $user->email,
                ],
            ]);

            $token = $transaction->generateToken();

            // Sauvegarder l'ID de transaction FedaPay
            $commande->update(['fedapay_transaction_id' => $transaction->id]);

            // Vider le panier avant la redirection
            Session::forget('cart');

            return redirect($token->url);

        } catch (\Exception $e) {
            // Si FedaPay échoue, supprimer la commande et informer l'utilisateur
            $commande->delete();

            return redirect()->route('checkout.index')
                ->with('error', 'Erreur lors de l\'initialisation du paiement. Veuillez réessayer.');
        }
    }

    /**
     * Callback FedaPay — appelé après le paiement (redirection navigateur)
     */
    public function fedapayCallback(Request $request, string $commandeId)
    {
        $commande = Commande::findOrFail($commandeId);

        // Vérifier que la commande appartient à l'utilisateur connecté
        if ($commande->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            \FedaPay\FedaPay::setApiKey(config('services.fedapay.secret_key'));
            \FedaPay\FedaPay::setEnvironment(config('services.fedapay.environment', 'sandbox'));

            $transaction = \FedaPay\Transaction::retrieve($commande->fedapay_transaction_id);

            if ($transaction->status === 'approved') {
                $commande->update([
                    'paiement_statut' => 'paye',
                    'statut'          => 'confirmé',
                ]);

                // Envoyer la notification email de confirmation
                /** @var \App\Models\User $user */
                $user = Auth::user();
                $user->notify(new OrderPlaced($commande));

                return redirect()->route('checkout.success', $commande->id);

            } else {
                $commande->update(['paiement_statut' => 'echec']);

                return redirect()->route('checkout.cancel')
                    ->with('error', 'Le paiement a échoué ou a été annulé. Votre commande a été conservée, vous pouvez réessayer.');
            }

        } catch (\Exception $e) {
            return redirect()->route('checkout.cancel')
                ->with('error', 'Impossible de vérifier le statut du paiement. Contactez le support.');
        }
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
