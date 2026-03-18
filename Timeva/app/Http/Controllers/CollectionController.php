<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $categorie = $request->get('categorie', 'tous');

        $query = Product::where('is_active', true)->with('variants')->latest();

        if ($categorie === 'watches') {
            $query->where('category', 'watches');
        } elseif ($categorie === 'glasses') {
            $query->where('category', 'glasses');
        }

        $produits = $query->paginate(12)->withQueryString();

        $counts = [
            'tous'    => Product::where('is_active', true)->count(),
            'watches' => Product::where('is_active', true)->where('category', 'watches')->count(),
            'glasses' => Product::where('is_active', true)->where('category', 'glasses')->count(),
        ];

        return view('pages.collections', compact('produits', 'categorie', 'counts'));
    }
}
