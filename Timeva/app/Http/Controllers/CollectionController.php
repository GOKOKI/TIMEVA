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

        $rawCounts = \Illuminate\Support\Facades\DB::table('products')
            ->selectRaw("SUM(1) as tous, SUM(CASE WHEN category='watches' THEN 1 ELSE 0 END) as watches, SUM(CASE WHEN category='glasses' THEN 1 ELSE 0 END) as glasses")
            ->where('is_active', true)
            ->first();

        $counts = [
            'tous'    => (int) $rawCounts->tous,
            'watches' => (int) $rawCounts->watches,
            'glasses' => (int) $rawCounts->glasses,
        ];

        return view('pages.collections', compact('produits', 'categorie', 'counts'));
    }
}
