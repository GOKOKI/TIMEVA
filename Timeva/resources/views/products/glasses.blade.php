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
        {{-- Correction : on utilise $products (en anglais comme dans le contrôleur) --}}
        @forelse($products as $product)
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow border border-gray-100">
            {{-- Correction de la route : on utilise 'products.show' avec le slug --}}
            <a href="{{ route('products.show', $product->slug) }}" class="block">
                <div class="aspect-square bg-gray-50 flex items-center justify-center p-8">
                    {{-- Correction : $product->image au lieu de $product->img --}}
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-contain">
                </div>
                <div class="p-4">
                    {{-- Correction : $product->brand au lieu de $product->marque --}}
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">{{ $product->brand ?? 'TIMEVA' }}</p>
                    {{-- Correction : $product->name au lieu de $product->nom --}}
                    <h4 class="text-lg font-semibold mb-2 text-gray-800">{{ $product->name }}</h4>
                    {{-- Correction : $product->prix reste le même --}}
                    <p class="text-xl font-bold mb-3 text-gray-900">{{ number_format($product->prix, 2, ',', ' ') }} €</p>
                    
                    {{-- Affichage des pastilles de couleurs des variantes --}}
                    @if($product->variants && $product->variants->isNotEmpty())
                        <div class="flex gap-2 mt-2">
                            @foreach($product->variants->pluck('color')->filter()->unique()->take(4) as $color)
                                <span class="w-4 h-4 rounded-full border border-gray-200" 
                                      style="background-color: {{ $color }};"
                                      title="{{ $color }}"></span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </a>
        </div>
        @empty
        <div class="col-span-full text-center py-20">
            <div class="text-gray-300 mb-4">
                <svg class="mx-auto w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M20 12H4M12 4v16" stroke-width="1" stroke-linecap="round"/>
                </svg>
            </div>
            <p class="text-gray-500 text-lg">Aucune paire de lunettes disponible pour le moment.</p>
        </div>
        @endforelse
    </div>

    @if(isset($products) && method_exists($products, 'links'))
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection