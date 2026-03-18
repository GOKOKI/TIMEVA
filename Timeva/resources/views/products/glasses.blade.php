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
        @forelse($products as $product)
        @php $totalStock = $product->variants ? $product->variants->sum('stock_quantity') : 0; @endphp
        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
            <a href="{{ route('products.show', $product->slug) }}" class="block">
                <div class="relative aspect-square bg-gray-100">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover transition-transform group-hover:scale-105 duration-500">
                    @if($totalStock > 0 && $totalStock <= 3)
                    <span class="absolute top-3 right-3 bg-white text-gray-800 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                        Plus que {{ $totalStock }}
                    </span>
                    @endif
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">{{ $product->brand ?? 'TIMEVA' }}</p>
                    <h4 class="text-base font-bold text-gray-900 mb-3">{{ $product->name }}</h4>
                    <div class="flex items-center justify-between">
                        <p class="text-base font-bold text-gray-900">{{ number_format($product->prix, 0, ',', ' ') }} FCFA</p>
                        @if($product->variants && $product->variants->isNotEmpty())
                        <div class="flex gap-1.5">
                            @foreach($product->variants->pluck('color')->filter()->unique()->take(4) as $color)
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