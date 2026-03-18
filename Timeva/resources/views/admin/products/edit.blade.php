@extends('admin.layout')

@section('title', 'Modifier — ' . $product->name)
@section('page-title', 'Modifier : ' . $product->name)

@section('content')
<div class="py-6 max-w-3xl space-y-6">

    {{-- Formulaire principal --}}
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">
            <h2 class="font-semibold text-gray-900">Informations du produit</h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Marque <span class="text-red-500">*</span></label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie <span class="text-red-500">*</span></label>
                    <select name="category" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                        <option value="watches" {{ $product->category === 'watches' ? 'selected' : '' }}>Montres</option>
                        <option value="glasses" {{ $product->category === 'glasses' ? 'selected' : '' }}>Lunettes</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prix (FCFA) <span class="text-red-500">*</span></label>
                    <input type="number" name="prix" value="{{ old('prix', $product->prix) }}" min="0" step="1" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image principale</label>
                    @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" class="w-20 h-20 object-cover rounded-lg mb-2">
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <p class="text-xs text-gray-400 mt-1">Laisser vide pour conserver l'image actuelle.</p>
                </div>
                <div class="flex items-center gap-3 pt-6">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ $product->is_active ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Produit actif</label>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 mt-6">
            <button type="submit"
                    class="bg-gray-900 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-black transition-colors">
                Enregistrer les modifications
            </button>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-900">
                Retour à la liste
            </a>
        </div>
    </form>

    {{-- ===== VARIANTES ===== --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-semibold text-gray-900 mb-4">Variantes ({{ $product->variants->count() }})</h2>

        @if($product->variants->isNotEmpty())
        <div class="space-y-2 mb-6">
            @foreach($product->variants as $variant)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center gap-4">
                    @if($variant->image_url)
                    <img src="{{ Storage::url($variant->image_url) }}" class="w-10 h-10 object-cover rounded">
                    @endif
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $variant->color }}
                            @if($variant->size) · {{ $variant->size }} @endif
                        </p>
                        <p class="text-xs text-gray-500">Stock : {{ $variant->stock_quantity }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}"
                      onsubmit="return confirm('Supprimer cette variante ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700">Supprimer</button>
                </form>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Ajouter une variante --}}
        <form method="POST" action="{{ route('admin.products.variants.store', $product) }}" enctype="multipart/form-data">
            @csrf
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Ajouter une variante</h3>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <input type="color" name="color" value="#000000" required
                           class="w-10 h-10 rounded cursor-pointer border border-gray-300 p-0.5">
                </div>
                <input type="text" name="size" placeholder="Taille"
                       class="w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-900">
                <input type="number" name="stock_quantity" placeholder="Stock" min="0" required
                       class="w-24 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-900">
                <input type="file" name="image_url" accept="image/*" class="text-xs">
                <button type="submit"
                        class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-black shrink-0">
                    Ajouter
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
