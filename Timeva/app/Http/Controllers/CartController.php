<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Panier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Afficher le contenu du panier
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        
        // Calcul du total global
        $total = collect($cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Ajouter une variante au panier
     */
    public function add(Request $request, $variantId)
    {
        // 1. Trouver la variante avec son produit parent
        $variant = ProductVariant::with('product')->findOrFail($variantId);
        
        // 2. Vérifier le stock
        $quantityToAdd = $request->input('quantity', 1);
        if ($variant->stock_quantity < $quantityToAdd) {
            return back()->with('error', 'Désolé, stock insuffisant.');
        }

        // 3. Récupérer le panier actuel en session
        $cart = Session::get('cart', []);

        // 4. Si la variante est déjà dans le panier, on incrémente la quantité
        if (isset($cart[$variantId])) {
            $cumul = $cart[$variantId]['quantity'] + $quantityToAdd;
            if ($cumul > $variant->stock_quantity) {
                return back()->with('error', 'Stock insuffisant pour cette quantité.');
            }
            $cart[$variantId]['quantity'] = $cumul;
        } else {
            // Sinon, on ajoute la nouvelle ligne
            $cart[$variantId] = [
                'name' => $variant->product->name,
                'variant_name' => trim(($variant->color ?? '') . ' ' . ($variant->size ?? '')),
                'price' => $variant->product->prix, // Utilisation de ton champ 'prix'
                'quantity' => $quantityToAdd,
                'image' => $variant->image_url ?? $variant->product->image,
                'slug' => $variant->product->slug
            ];
        }

        Session::put('cart', $cart);
        $this->syncToDb($variantId, $cart[$variantId]['quantity'], $variant->product->prix);

        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier !');
    }

    /**
     * Mettre à jour la quantité d'une variante
     */
    public function update(Request $request, $variantId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$variantId])) {
            $newQty = (int) $request->input('quantity');

            $variant = ProductVariant::find($variantId);
            if ($variant && $newQty <= $variant->stock_quantity) {
                $cart[$variantId]['quantity'] = $newQty;
                Session::put('cart', $cart);
                $this->syncToDb($variantId, $newQty, $cart[$variantId]['price']);
                return back()->with('success', 'Panier mis à jour.');
            }
        }

        return back()->with('error', 'Impossible de mettre à jour la quantité.');
    }

    /**
     * Retirer une variante du panier
     */
    public function remove($variantId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$variantId])) {
            unset($cart[$variantId]);
            Session::put('cart', $cart);
            $this->syncToDb($variantId, 0, 0);
        }

        return back()->with('success', 'Produit retiré du panier.');
    }

    /**
     * Vider le panier
     */
    public function clear()
    {
        Session::forget('cart');

        if (Auth::check()) {
            Panier::where('user_id', Auth::id())->delete();
        }

        return back()->with('success', 'Le panier a été vidé.');
    }

    /**
     * Synchronise un article du panier en session avec la table paniers (DB)
     * Quantity = 0 signifie suppression de la ligne
     */
    private function syncToDb(int $variantId, int $quantity, float $prix): void
    {
        if (!Auth::check()) {
            return;
        }

        if ($quantity <= 0) {
            Panier::where('user_id', Auth::id())
                ->where('variant_id', $variantId)
                ->delete();
        } else {
            Panier::updateOrCreate(
                ['user_id' => Auth::id(), 'variant_id' => $variantId],
                ['quantite' => $quantity, 'prix_unitaire' => $prix]
            );
        }
    }
}