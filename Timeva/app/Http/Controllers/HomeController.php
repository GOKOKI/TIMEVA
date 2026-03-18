<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Mix 4 montres + 4 lunettes pour la section Produits Vedettes
        $montres = Product::where('category', 'watches')
            ->where('is_active', true)
            ->with('variants')
            ->latest()
            ->limit(4)
            ->get();

        $lunettes = Product::where('category', 'glasses')
            ->where('is_active', true)
            ->with('variants')
            ->latest()
            ->limit(4)
            ->get();

        $produitsVedettes = $montres->merge($lunettes);

        return view('welcome', compact('produitsVedettes'));
    }
}
