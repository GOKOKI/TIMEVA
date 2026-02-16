@extends('layout.app')
@section('title', 'Montres')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h3 class="text-3xl font-bold mb-2 flex items-center gap-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="8" stroke-width="2"/>
                <path d="M12 6v6l4 2" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Montres
        </h3>
        <p class="text-gray-600">Découvrez notre collection de montres de luxe, alliant tradition horlogère et design contemporain.</p>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($produits as $produit)
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow group">
            <a href="{{ route('products.show', $produit) }}" class="block">
                <div class="aspect-square bg-gray-100 flex items-center justify-center p-8 group-hover:bg-gray-200 transition-colors">
                    <img src="{{ $produit->img ?? asset('images/placeholder-watch.jpg') }}" 
                         alt="{{ $produit->nom }}" 
                         class="w-full h-full object-contain transition-transform group-hover:scale-110 duration-300">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ $produit->marque ?? 'TIMEVA' }}</p>
                    <h4 class="text-lg font-semibold mb-2 group-hover:text-gray-900">{{ $produit->nom }}</h4>
                    <p class="text-xl font-bold mb-3">{{ number_format($produit->prix, 2) }} €</p>
                    
                    @if($produit->variantes->isNotEmpty())
                        <div class="flex gap-2">
                            @foreach($produit->variantes->pluck('couleur')->filter()->unique()->take(4) as $couleur)
                                <span class="w-5 h-5 rounded-full border-2 border-gray-300 cursor-pointer hover:scale-110 transition-transform" 
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
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="8" stroke-width="2"/>
                <path d="M12 6v6l4 2" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Aucune montre disponible</h3>
            <p class="text-gray-600 mb-6">Nos nouvelles collections arrivent bientôt !</p>
            <a href="{{ route('home') }}" class="inline-block bg-gray-900 text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors">
                Retour à l'accueil
            </a>
        </div>
        @endforelse
    </div>

    @if(isset($produits) && method_exists($produits, 'links'))
        <div class="mt-8">
            {{ $produits->links() }}
        </div>
    @endif
</div>
@endsection