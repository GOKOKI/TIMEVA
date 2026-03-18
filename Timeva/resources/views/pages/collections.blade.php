@extends('layout.app')

@section('title', 'Toutes les collections — TIMEVA')

@section('content')
<div class="container mx-auto px-4 py-12">

    {{-- En-tête --}}
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Toutes les collections</h1>
        <p class="text-gray-500">Montres et lunettes de luxe — {{ $counts['tous'] }} produits</p>
    </div>

    {{-- Onglets filtre --}}
    <div class="flex items-center gap-2 mb-8 border-b border-gray-200">
        @php
            $tabs = [
                'tous'    => ['label' => 'Tous', 'count' => $counts['tous']],
                'watches' => ['label' => 'Montres', 'count' => $counts['watches']],
                'glasses' => ['label' => 'Lunettes', 'count' => $counts['glasses']],
            ];
        @endphp

        @foreach($tabs as $key => $tab)
        <a href="{{ route('collections', $key !== 'tous' ? ['categorie' => $key] : []) }}"
           class="px-5 py-3 text-sm font-medium border-b-2 -mb-px transition-colors
                  {{ $categorie === $key || ($key === 'tous' && $categorie === 'tous')
                      ? 'border-gray-900 text-gray-900'
                      : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            {{ $tab['label'] }}
            <span class="ml-1 text-xs text-gray-400">({{ $tab['count'] }})</span>
        </a>
        @endforeach
    </div>

    {{-- Grille produits --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($produits as $produit)
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow group border border-gray-100">
            <a href="{{ route('products.show', $produit->slug) }}" class="block">
                <div class="aspect-square bg-gray-50 flex items-center justify-center p-8 group-hover:bg-gray-100 transition-colors">
                    <img src="{{ $produit->image ? asset('storage/' . $produit->image) : asset('images/placeholder.jpg') }}"
                         alt="{{ $produit->name }}"
                         class="w-full h-full object-contain transition-transform group-hover:scale-110 duration-300">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">{{ $produit->brand ?? 'TIMEVA' }}</p>
                    <h4 class="text-lg font-semibold mb-2 group-hover:text-gray-900 text-gray-800">{{ $produit->name }}</h4>
                    <p class="text-xl font-bold mb-3 text-gray-900">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</p>
                    @if($produit->variants->isNotEmpty())
                    <div class="flex gap-2">
                        @foreach($produit->variants->pluck('color')->filter()->unique()->take(4) as $color)
                        <span class="w-5 h-5 rounded-full border-2 border-gray-200 cursor-pointer hover:scale-110 transition-transform"
                              style="background-color: {{ $color }};"
                              title="{{ $color }}"></span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </a>
        </div>
        @empty
        <div class="col-span-full text-center py-20 text-gray-400">
            <p class="text-lg">Aucun produit dans cette catégorie.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($produits->hasPages())
    <div class="mt-12">
        {{ $produits->links() }}
    </div>
    @endif

</div>
@endsection
