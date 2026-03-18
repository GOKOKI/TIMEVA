@extends('admin.layout')

@section('title', 'Nouveau produit')
@section('page-title', 'Ajouter un produit')

@section('content')
<div class="py-6 max-w-3xl">

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
          x-data="{ variants: [] }">
        @csrf

        <div class="space-y-6">

            {{-- Informations principales --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">
                <h2 class="font-semibold text-gray-900">Informations du produit</h2>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Marque <span class="text-red-500">*</span></label>
                        <input type="text" name="brand" value="{{ old('brand') }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                        @error('brand') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie <span class="text-red-500">*</span></label>
                        <select name="category" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                            <option value="">Sélectionner...</option>
                            <option value="watches" {{ old('category') === 'watches' ? 'selected' : '' }}>Montres</option>
                            <option value="glasses" {{ old('category') === 'glasses' ? 'selected' : '' }}>Lunettes</option>
                        </select>
                        @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prix (FCFA) <span class="text-red-500">*</span></label>
                        <input type="number" name="prix" value="{{ old('prix') }}" min="0" step="1" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                        @error('prix') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image principale</label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center gap-3 pt-6">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', '1') ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300">
                        <label for="is_active" class="text-sm font-medium text-gray-700">Produit actif (visible sur le site)</label>
                    </div>
                </div>
            </div>

            {{-- Variantes --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-gray-900">Variantes (couleur / taille / stock)</h2>
                    <button type="button" @click="variants.push({ color: '', size: '', stock_quantity: 0 })"
                            class="text-sm text-gray-900 font-medium border border-gray-300 px-3 py-1.5 rounded-lg hover:bg-gray-50">
                        + Ajouter une variante
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(variant, index) in variants" :key="index">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <input type="text" :name="`variants[${index}][color]`" x-model="variant.color"
                                       placeholder="Couleur *" required
                                       class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-gray-900">
                            </div>
                            <div class="flex-1">
                                <input type="text" :name="`variants[${index}][size]`" x-model="variant.size"
                                       placeholder="Taille (optionnel)"
                                       class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-gray-900">
                            </div>
                            <div class="w-28">
                                <input type="number" :name="`variants[${index}][stock_quantity]`" x-model="variant.stock_quantity"
                                       placeholder="Stock" min="0" required
                                       class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-gray-900">
                            </div>
                            <div>
                                <input type="file" :name="`variants[${index}][image_url]`" accept="image/*"
                                       class="text-xs">
                            </div>
                            <button type="button" @click="variants.splice(index, 1)"
                                    class="text-red-500 hover:text-red-700 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </template>

                    <p x-show="variants.length === 0" class="text-sm text-gray-400 text-center py-4">
                        Aucune variante — cliquez sur "Ajouter une variante" ci-dessus.
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-4">
                <button type="submit"
                        class="bg-gray-900 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-black transition-colors">
                    Créer le produit
                </button>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-900">
                    Annuler
                </a>
            </div>

        </div>
    </form>

</div>
@endsection
