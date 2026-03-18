<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::withCount('variants')->orderByDesc('created_at');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'required|string|max:255',
            'category'    => 'required|in:watches,glasses',
            'description' => 'nullable|string',
            'prix'        => 'required|numeric|min:0',
            'is_active'   => 'boolean',
            'image'       => 'nullable|image|max:2048',
            'variants'    => 'nullable|array',
            'variants.*.color'          => 'required|string|max:100',
            'variants.*.size'           => 'nullable|string|max:50',
            'variants.*.stock_quantity' => 'required|integer|min:0',
            'variants.*.image_url'      => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'name'        => $validated['name'],
            'brand'       => $validated['brand'],
            'category'    => $validated['category'],
            'description' => $validated['description'] ?? null,
            'prix'        => $validated['prix'],
            'is_active'   => $request->boolean('is_active', true),
            'image'       => $imagePath,
            'slug'        => Str::slug($validated['name']),
        ]);

        if (!empty($validated['variants'])) {
            foreach ($validated['variants'] as $index => $variantData) {
                $variantImagePath = null;
                if ($request->hasFile("variants.{$index}.image_url")) {
                    $variantImagePath = $request->file("variants.{$index}.image_url")
                        ->store('products/variants', 'public');
                }

                ProductVariant::create([
                    'product_id'     => $product->id,
                    'color'          => $variantData['color'],
                    'size'           => $variantData['size'] ?? null,
                    'stock_quantity' => $variantData['stock_quantity'],
                    'image_url'      => $variantImagePath,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit "' . $product->name . '" créé avec succès.');
    }

    public function edit(Product $product)
    {
        $product->load('variants');
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'required|string|max:255',
            'category'    => 'required|in:watches,glasses',
            'description' => 'nullable|string',
            'prix'        => 'required|numeric|min:0',
            'is_active'   => 'boolean',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $validated['name'],
            'brand'       => $validated['brand'],
            'category'    => $validated['category'],
            'description' => $validated['description'] ?? null,
            'prix'        => $validated['prix'],
            'is_active'   => $request->boolean('is_active', true),
            'image'       => $validated['image'] ?? $product->image,
        ]);

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé.');
    }

    // Ajouter une variante à un produit existant
    public function storeVariant(Request $request, Product $product)
    {
        $validated = $request->validate([
            'color'          => 'required|string|max:100',
            'size'           => 'nullable|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
            'image_url'      => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('products/variants', 'public');
        }

        ProductVariant::create([
            'product_id'     => $product->id,
            'color'          => $validated['color'],
            'size'           => $validated['size'] ?? null,
            'stock_quantity' => $validated['stock_quantity'],
            'image_url'      => $imagePath,
        ]);

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Variante ajoutée.');
    }

    public function destroyVariant(Product $product, ProductVariant $variant)
    {
        if ($variant->image_url) {
            Storage::disk('public')->delete($variant->image_url);
        }

        $variant->delete();

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Variante supprimée.');
    }
}
