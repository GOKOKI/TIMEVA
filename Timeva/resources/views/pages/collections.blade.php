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
        @php $totalStock = $produit->variants->sum('stock_quantity'); @endphp
        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
            <a href="{{ route('products.show', $produit->slug) }}" class="block">
                <div class="relative aspect-square bg-gray-100">
                    <img src="{{ $produit->image ? asset('storage/' . $produit->image) : asset('images/placeholder.jpg') }}"
                         alt="{{ $produit->name }}"
                         class="w-full h-full object-cover transition-transform group-hover:scale-105 duration-500">
                    @if($totalStock > 0 && $totalStock <= 3)
                    <span class="absolute top-3 right-3 bg-white text-gray-800 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                        Plus que {{ $totalStock }}
                    </span>
                    @endif
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">{{ $produit->brand ?? 'TIMEVA' }}</p>
                    <h4 class="text-base font-bold text-gray-900 mb-3">{{ $produit->name }}</h4>
                    <div class="flex items-center justify-between">
                        <p class="text-base font-bold text-gray-900">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</p>
                        @if($produit->variants->isNotEmpty())
                        <div class="flex gap-1.5">
                            @foreach($produit->variants->pluck('color')->filter()->unique()->take(4) as $color)
                            <span class="w-4 h-4 rounded-full border border-gray-200"
                                  style="background-color: {{ $color }};"
                                  title="{{ $color }}"></span>
                            @endforeach
                        </div>
                        @endif
                    </div>
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
