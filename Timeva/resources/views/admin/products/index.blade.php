@extends('admin.layout')

@section('title', 'Produits')
@section('page-title', 'Gestion des Produits')

@section('content')
<div class="py-6 space-y-6">

    {{-- Header + actions --}}
    <div class="flex items-center justify-between">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Rechercher un produit..."
                   class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-gray-900">
            <select name="category" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                <option value="">Toutes catégories</option>
                <option value="watches" {{ request('category') === 'watches' ? 'selected' : '' }}>Montres</option>
                <option value="glasses" {{ request('category') === 'glasses' ? 'selected' : '' }}>Lunettes</option>
            </select>
            <button type="submit" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium">Filtrer</button>
        </form>
        <a href="{{ route('admin.products.create') }}"
           class="bg-gray-900 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-black transition-colors">
            + Nouveau produit
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-left text-xs text-gray-500 uppercase tracking-wide bg-gray-50">
                    <th class="px-6 py-3">Produit</th>
                    <th class="px-6 py-3">Catégorie</th>
                    <th class="px-6 py-3">Prix</th>
                    <th class="px-6 py-3">Variantes</th>
                    <th class="px-6 py-3">Statut</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                 class="w-10 h-10 rounded-lg object-cover bg-gray-100">
                            @else
                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->brand }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">
                            {{ $product->category === 'watches' ? 'Montre' : 'Lunette' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold">{{ number_format($product->prix, 0, ',', ' ') }} FCFA</td>
                    <td class="px-6 py-4 text-gray-600">{{ $product->variants_count }} variante(s)</td>
                    <td class="px-6 py-4">
                        @if($product->is_active)
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Actif</span>
                        @else
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Inactif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Modifier</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Supprimer ce produit ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        Aucun produit trouvé.
                        <a href="{{ route('admin.products.create') }}" class="text-gray-900 underline ml-1">Ajouter le premier</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
