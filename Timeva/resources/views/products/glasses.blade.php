@extends('layout.app')
@section('title', 'Glasses')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h3 class="text-3xl font-bold mb-2 flex items-center gap-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M2 12h4m12 0h4M6 12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2M6 12c0-1.1.9-2 2-2h8c1.1 0 2 .9 2 2" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Glasses
        </h3>
        <p class="text-gray-600">Explorez notre sélection de lunettes raffinées, où style et qualité se rencontrent.</p>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($produits as $produit)
        <!-- Produit -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
            <a href="{{ route('products.show', $produit) }}" class="block">
                <div class="aspect-square bg-gray-100 flex items-center justify-center p-8">
                    <img src="{{ $produit->img ?? asset('images/placeholder.jpg') }}" 
                         alt="{{ $produit->nom }}" 
                         class="w-full h-full object-contain">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ $produit->marque ?? 'TIMEVA' }}</p>
                    <h4 class="text-lg font-semibold mb-2">{{ $produit->nom }}</h4>
                    <p class="text-xl font-bold mb-3">{{ number_format($produit->prix, 2) }} €</p>
                    
                    @if($produit->variantes->isNotEmpty())
                        <div class="flex gap-2">
                            @foreach($produit->variantes->pluck('couleur')->filter()->unique()->take(4) as $couleur)
                                <span class="w-5 h-5 rounded-full border-2 border-gray-300 cursor-pointer" 
                                      style="background-color: {{ $couleur }};"
                                      title="{{ $couleur }}"></span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </a>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500">Aucun produit disponible pour le moment.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($produits) && method_exists($produits, 'links'))
        <div class="mt-8">
            {{ $produits->links() }}
        </div>
    @endif
</div>
@endsection