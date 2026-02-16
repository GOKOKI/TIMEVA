<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\VarianteProduit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Afficher toutes les montres
     */
    public function watches()
    {
        // Récupère les produits de catégorie 'montres' avec leurs variantes en stock
        $produits = Produit::where('categorie', 'montres')
                          ->where('disponible', true)
                          ->with(['variantes' => function ($query) {
                              $query->where('quantite_stock', '>', 0);
                          }])
                          ->paginate(12);

        return view('products.watches', compact('produits'));
    }

    /**
     * Afficher toutes les lunettes
     */
    public function glasses()
    {
        // Récupère les produits de catégorie 'lunettes' avec leurs variantes en stock
        $produits = Produit::where('categorie', 'lunettes')
                          ->where('disponible', true)
                          ->with(['variantes' => function ($query) {
                              $query->where('quantite_stock', '>', 0);
                          }])
                          ->paginate(12);

        return view('products.glasses', compact('produits'));
    }

    /**
     * Afficher le détail d'une montre
     */
    public function watchesshow($id)
    {
        // Récupère le produit avec toutes ses variantes
        $produit = Produit::where('categorie', 'montres')
                         ->with('variantes')
                         ->findOrFail($id);

        // Produits similaires (même marque ou même gamme de prix)
        $similaires = Produit::where('categorie', 'montres')
                            ->where('id', '!=', $produit->id)
                            ->where('disponible', true)
                            ->where(function ($query) use ($produit) {
                                $query->where('marque', $produit->marque)
                                      ->orWhereBetween('prix', [
                                          $produit->prix * 0.7,
                                          $produit->prix * 1.3
                                      ]);
                            })
                            ->with(['variantes' => function ($query) {
                                $query->where('quantite_stock', '>', 0);
                            }])
                            ->limit(4)
                            ->get();

        return view('products.watchesshow', compact('produit', 'similaires'));
    }

    /**
     * Afficher le détail d'une lunette
     */
    public function glassesshow($id)
    {
        // Récupère le produit avec toutes ses variantes
        $produit = Produit::where('categorie', 'lunettes')
                         ->with('variantes')
                         ->findOrFail($id);

        // Produits similaires (même marque ou même gamme de prix)
        $similaires = Produit::where('categorie', 'lunettes')
                            ->where('id', '!=', $produit->id)
                            ->where('disponible', true)
                            ->where(function ($query) use ($produit) {
                                $query->where('marque', $produit->marque)
                                      ->orWhereBetween('prix', [
                                          $produit->prix * 0.7,
                                          $produit->prix * 1.3
                                      ]);
                            })
                            ->with(['variantes' => function ($query) {
                                $query->where('quantite_stock', '>', 0);
                            }])
                            ->limit(4)
                            ->get();

        return view('products.glassesshow', compact('produit', 'similaires'));
    }

    /**
     * Méthode générique avec slug (recommandée)
     */
    public function show($categorie, $slug, $id = null)
    {
        // Si on a un ID, on l'utilise
        if ($id) {
            $produit = Produit::where('categorie', $categorie)
                             ->with('variantes')
                             ->findOrFail($id);
        } else {
            // Sinon on cherche par slug (à implémenter si tu ajoutes un champ slug)
            $produit = Produit::where('categorie', $categorie)
                             ->where('slug', $slug)
                             ->with('variantes')
                             ->firstOrFail();
        }

        $similaires = Produit::where('categorie', $categorie)
                            ->where('id', '!=', $produit->id)
                            ->where('disponible', true)
                            ->inRandomOrder()
                            ->limit(4)
                            ->get();

        $view = $categorie === 'montres' ? 'products.watchesshow' : 'products.glassesshow';
        
        return view($view, compact('produit', 'similaires'));
    }
}