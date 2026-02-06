<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.cart');
    }

    public function add($productId)
    {
        // Ajouter un produit au panier
    }

    public function remove($productId)
    {
        // Retirer un produit du panier
    }

    public function check()
    {
        return view('cart.checkout');
    }

    public function orders()
    {
        return view('profile.commandes');
    }
}
