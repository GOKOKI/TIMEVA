<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\VarianteProduit;
use App\Models\Commande;
use App\Models\ArticleCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Constructeur - protège les routes sauf index
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Afficher le panier
     */
    public function index()
    {
        $cartItems = collect();
        $total = 0;
        $count = 0;

        if (Auth::check()) {
            // Utilisateur connecté - panier BDD
            $cartItems = Panier::with('variante.produit')
                              ->where('user_id', Auth::id())
                              ->get();
            
            $total = $cartItems->sum(function ($item) {
                return $item->variante->prix_final * $item->quantite;
            });
            
            $count = $cartItems->sum('quantite');
        } else {
            // Visiteur - panier session (à implémenter)
            $cartItems = session()->get('cart', []);
            
        }

        return view('cart.cart', compact('cartItems', 'total', 'count'));
    }

    /**
     * Ajouter une variante au panier
     */
    public function add(Request $request, $variantId)
    {
        // Validation
        $request->validate([
            'quantite' => 'required|integer|min:1|max:99'
        ]);

        // Récupérer la variante
        $variante = VarianteProduit::with('produit')->findOrFail($variantId);

        // Vérifier le stock
        if ($variante->quantite_stock < $request->quantite) {
            return back()->with('error', 'Stock insuffisant. Stock disponible: ' . $variante->quantite_stock);
        }

        if (Auth::check()) {
            // UTILISATEUR CONNECTÉ - Sauvegarde en BDD
            $panier = Panier::where('user_id', Auth::id())
                           ->where('variant_id', $variantId)
                           ->first();

            if ($panier) {
                // Mise à jour quantité
                $nouvelleQuantite = $panier->quantite + $request->quantite;
                
                // Vérifier le stock pour la nouvelle quantité
                if ($variante->quantite_stock < $nouvelleQuantite) {
                    return back()->with('error', 'Stock insuffisant. Vous avez déjà ' . $panier->quantite . ' article(s) dans votre panier.');
                }
                
                $panier->update([
                    'quantite' => $nouvelleQuantite,
                    'date_modification' => now()
                ]);
            } else {
                // Nouvel article
                Panier::create([
                    'id' => Str::uuid(),
                    'user_id' => Auth::id(),
                    'variant_id' => $variantId,
                    'quantite' => $request->quantite,
                    'date_creation' => now(),
                    'date_modification' => now()
                ]);
            }
        } else {
            // VISITEUR NON CONNECTÉ - Session
            $cart = session()->get('cart', []);
            
            if (isset($cart[$variantId])) {
                $cart[$variantId]['quantite'] += $request->quantite;
            } else {
                $cart[$variantId] = [
                    'id' => $variante->id_variant,
                    'nom' => $variante->produit->nom,
                    'couleur' => $variante->couleur,
                    'taille' => $variante->taille,
                    'prix' => $variante->prix_final,
                    'img' => $variante->image,
                    'quantite' => $request->quantite,
                    'stock' => $variante->quantite_stock
                ];
            }
            
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')
                        ->with('success', 'Produit ajouté au panier !');
    }

    /**
     * Mettre à jour la quantité
     */
    public function update(Request $request, $variantId)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1|max:99'
        ]);

        $variante = VarianteProduit::findOrFail($variantId);

        // Vérifier le stock
        if ($variante->quantite_stock < $request->quantite) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuffisant. Maximum: ' . $variante->quantite_stock
            ], 422);
        }

        if (Auth::check()) {
            // BDD
            $panier = Panier::where('user_id', Auth::id())
                           ->where('variant_id', $variantId)
                           ->firstOrFail();
            
            $panier->update([
                'quantite' => $request->quantite,
                'date_modification' => now()
            ]);

            // Calculer nouveaux totaux
            $sousTotal = $panier->variante->prix_final * $request->quantite;
            $total = $this->getCartTotal();
            
        } else {
            // Session
            $cart = session()->get('cart', []);
            if (isset($cart[$variantId])) {
                $cart[$variantId]['quantite'] = $request->quantite;
                session()->put('cart', $cart);
                
                $sousTotal = $cart[$variantId]['prix'] * $request->quantite;
                $total = $this->getCartTotal();
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'sous_total' => number_format($sousTotal, 2),
                'total' => number_format($total, 2),
                'count' => $this->getCartCount()
            ]);
        }

        return redirect()->route('cart.index')
                        ->with('success', 'Panier mis à jour');
    }

    /**
     * Retirer un article du panier
     */
    public function remove($variantId)
    {
        if (Auth::check()) {
            // BDD
            Panier::where('user_id', Auth::id())
                  ->where('variant_id', $variantId)
                  ->delete();
        } else {
            // Session
            $cart = session()->get('cart', []);
            unset($cart[$variantId]);
            session()->put('cart', $cart);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Article retiré du panier',
                'total' => number_format($this->getCartTotal(), 2),
                'count' => $this->getCartCount()
            ]);
        }

        return redirect()->route('cart.index')
                        ->with('success', 'Article retiré du panier');
    }

    /**
     * Vider le panier
     */
    public function clear()
    {
        if (Auth::check()) {
            // BDD
            Panier::where('user_id', Auth::id())->delete();
        } else {
            // Session
            session()->forget('cart');
        }

        return redirect()->route('cart.index')
                        ->with('success', 'Panier vidé');
    }

    /**
     * Page de checkout
     */
    public function checkout()
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')
                            ->with('error', 'Veuillez vous connecter pour finaliser votre commande');
        }

        // Vérifier que le panier n'est pas vide
        $panier = Panier::with('variante.produit')
                       ->where('user_id', Auth::id())
                       ->get();

        if ($panier->isEmpty()) {
            return redirect()->route('cart.index')
                            ->with('error', 'Votre panier est vide');
        }

        // Vérifier le stock pour chaque article
        foreach ($panier as $article) {
            if ($article->quantite > $article->variante->quantite_stock) {
                return redirect()->route('cart.index')
                                ->with('error', 'Stock insuffisant pour ' . $article->variante->produit->nom);
            }
        }

        // Récupérer le profil de l'utilisateur
        $profil = Auth::user()->profil;

        if (!$profil) {
            return redirect()->route('profile.edit')
                            ->with('warning', 'Veuillez compléter votre profil avant de commander');
        }

        $total = $this->getCartTotal();

        return view('cart.checkout', compact('panier', 'profil', 'total'));
    }

    /**
     * Traiter la commande
     */
    public function processOrder(Request $request)
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

            // Récupérer le panier
            $panier = Panier::with('variante.produit')
                           ->where('user_id', Auth::id())
                           ->get();

            if ($panier->isEmpty()) {
                throw new \Exception('Panier vide');
            }

            // Calculer le total
            $total = $this->getCartTotal();

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

            // Créer les articles commandés et mettre à jour le stock
            foreach ($panier as $article) {
                // Créer l'article commandé
                ArticleCommande::create([
                    'id_article' => Str::uuid(),
                    'commande_id' => $commande->id,
                    'variant_id' => $article->variant_id,
                    'nom_produit' => $article->variante->produit->nom,
                    'infos_variante' => json_encode([
                        'couleur' => $article->variante->couleur,
                        'taille' => $article->variante->taille,
                        'reference' => $article->variante->reference,
                        'img' => $article->variante->image
                    ]),
                    'prix_unitaire' => $article->variante->prix_final,
                    'quantite' => $article->quantite,
                    'date_creation' => now()
                ]);

                // Mettre à jour le stock
                $article->variante->decrement('quantite_stock', $article->quantite);
            }

            // Vider le panier
            Panier::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('checkout.success', $commande->id)
                            ->with('success', 'Commande validée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la commande: ' . $e->getMessage());
        }
    }

    /**
     * Page de succès de commande
     */
    public function success($commandeId)
    {
        $commande = Commande::with('articles')
                           ->where('user_id', Auth::id())
                           ->findOrFail($commandeId);

        return view('cart.success', compact('commande'));
    }

    /**
     * Historique des commandes
     */
    public function orders()
    {
        $commandes = Commande::with('articles')
                            ->where('user_id', Auth::id())
                            ->orderBy('date_creation', 'desc')
                            ->paginate(10);

        return view('profile.commandes', compact('commandes'));
    }

    /**
     * Détail d'une commande
     */
    public function orderDetails($commandeId)
    {
        $commande = Commande::with('articles.variante')
                           ->where('user_id', Auth::id())
                           ->findOrFail($commandeId);

        return view('profile.commande-details', compact('commande'));
    }

    /**
     * Calculer le total du panier
     */
    private function getCartTotal()
    {
        if (Auth::check()) {
            return Panier::with('variante')
                        ->where('user_id', Auth::id())
                        ->get()
                        ->sum(function ($item) {
                            return $item->variante->prix_final * $item->quantite;
                        });
        } else {
            $cart = session()->get('cart', []);
            return collect($cart)->sum(function ($item) {
                return $item['prix'] * $item['quantite'];
            });
        }
    }

    /**
     * Compter le nombre d'articles
     */
    private function getCartCount()
    {
        if (Auth::check()) {
            return Panier::where('user_id', Auth::id())->sum('quantite');
        } else {
            $cart = session()->get('cart', []);
            return collect($cart)->sum('quantite');
        }
    }
}