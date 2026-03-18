<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Mix 2 montres + 2 lunettes pour la section Produits Vedettes
        $montres = Product::where('category', 'watches')
            ->where('is_active', true)
            ->with('variants')
            ->latest()
            ->limit(2)
            ->get();

        $lunettes = Product::where('category', 'glasses')
            ->where('is_active', true)
            ->with('variants')
            ->latest()
            ->limit(2)
            ->get();

        $produitsVedettes = $montres->merge($lunettes);

        return view('welcome', compact('produitsVedettes'));
    }
}
