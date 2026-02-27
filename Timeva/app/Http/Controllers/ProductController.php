<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Afficher la liste des montres
     */
    public function watches()
    {
        $products = $this->getActiveProducts('watches');
        return view('products.watches', compact('products'));
    }

    /**
     * Afficher la liste des lunettes
     */
    public function glasses()
    {
        $products = $this->getActiveProducts('glasses');
        return view('products.glasses', compact('products'));
    }

    /**
     * Récupère les produits actifs d'une catégorie avec pagination
     */
    private function getActiveProducts(string $category)
    {
        return Product::where('category', $category)
            ->where('is_active', true)
            ->paginate(12);
    }

    /**
     * Afficher les détails d'un produit en fonction de son slug
     */
    public function show($slug)
    {
        // 1. On récupère le produit actif avec ses variantes (Eager Loading)
        $product = Product::with('variants')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // 2. On récupère 4 produits similaires actifs de la même catégorie (sauf le produit actuel)
        $similaires = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        // 3. On envoie tout à la vue (compact utilise les noms de variables)
        return view('products.show', compact('product', 'similaires'));
    }
}