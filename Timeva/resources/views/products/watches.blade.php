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
        {{-- Correction : on utilise $products envoyé par le contrôleur --}}
        @forelse($products as $product)
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow group border border-gray-100">
            {{-- Correction : route vers 'products.show' avec le slug --}}
            <a href="{{ route('products.show', $product->slug) }}" class="block">
                <div class="aspect-square bg-gray-50 flex items-center justify-center p-8 group-hover:bg-gray-100 transition-colors">
                    {{-- Correction : $product->image --}}
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder-watch.jpg') }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-contain transition-transform group-hover:scale-110 duration-300">
                </div>
                <div class="p-4">
                    {{-- Correction : $product->brand --}}
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">{{ $product->brand ?? 'TIMEVA' }}</p>
                    {{-- Correction : $product->name --}}
                    <h4 class="text-lg font-semibold mb-2 group-hover:text-gray-900 text-gray-800">{{ $product->name }}</h4>
                    <p class="text-xl font-bold mb-3 text-gray-900">{{ number_format($product->prix, 2, ',', ' ') }} €</p>
                    
                    {{-- Correction : $product->variants et couleur (en anglais) --}}
                    @if($product->variants && $product->variants->isNotEmpty())
                        <div class="flex gap-2">
                            @foreach($product->variants->pluck('color')->filter()->unique()->take(4) as $color)
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
        <div class="col-span-full text-center py-20 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="8" stroke-width="2"/>
                <path d="M12 6v6l4 2" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Aucune montre disponible</h3>
            <p class="text-gray-600 mb-6">Nos nouvelles collections arrivent bientôt !</p>
            <a href="{{ route('home') }}" class="inline-block bg-gray-900 text-white px-8 py-3 rounded-full hover:bg-black transition-colors shadow-lg">
                Retour à l'accueil
            </a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(isset($products) && method_exists($products, 'links'))
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection