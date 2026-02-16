<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class HomeController extends Controller
{
        public function index()
    {
        // Récupérer 4 produits vedettes (par exemple les plus récents)
        $produitsVedettes = Produit::with('variantes')
                                  ->where('disponible', true)
                                  ->latest()
                                  ->take(4)
                                  ->get();
        
        return view('home', compact('produitsVedettes'));
    }
}
