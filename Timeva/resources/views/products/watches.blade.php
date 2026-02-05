@extends('layout.app')
@section('title', 'Watches')
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
        <!-- Produit 1 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
            <a href="{{ route('product.watchesshow', ['product' => 1]) }}" class="block">
                <div class="aspect-square bg-gray-100 flex items-center justify-center p-8">
                    <img src="{{ asset('images/watches1.jpg') }}" alt="Chronographe Royal" class="w-full h-full object-contain">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">TIMEVA</p>
                    <h4 class="text-lg font-semibold mb-2">Chronographe Royal</h4>
                    <p class="text-xl font-bold mb-3">2350.00 €</p>
                    <div class="flex gap-2">
                        <span class="w-5 h-5 rounded-full bg-gray-300 border-2 border-gray-400 cursor-pointer"></span>
                        <span class="w-5 h-5 rounded-full bg-black border-2 border-gray-300 cursor-pointer"></span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Produit 2 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
            <a href="{{ route('product.watchesshow', ['product' => 2]) }}" class="block">
                <div class="aspect-square bg-gray-100 flex items-center justify-center p-8">
                    <img src="{{ asset('images/watches2.jpg') }}" alt="Classique Or Rose" class="w-full h-full object-contain">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">TIMEVA</p>
                    <h4 class="text-lg font-semibold mb-2">Classique Or Rose</h4>
                    <p class="text-xl font-bold mb-3">3740.00 €</p>
                    <div class="flex gap-2">
                        <span class="w-5 h-5 rounded-full bg-rose-400 border-2 border-gray-300 cursor-pointer"></span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Produit 3 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
            <a href="{{ route('product.watchesshow', ['product' => 3]) }}" class="block">
                <div class="aspect-square bg-gray-100 flex items-center justify-center p-8">
                    <img src="{{ asset('images/watches3.jpg') }}" alt="Sport Titanium" class="w-full h-full object-contain">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">TIMEVA</p>
                    <h4 class="text-lg font-semibold mb-2">Sport Titanium</h4>
                    <p class="text-xl font-bold mb-3">1850.00 €</p>
                    <div class="flex gap-2">
                        <span class="w-5 h-5 rounded-full bg-gray-400 border-2 border-gray-300 cursor-pointer"></span>
                        <span class="w-5 h-5 rounded-full bg-black border-2 border-gray-300 cursor-pointer"></span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Produit 4 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow relative">
            <a href="{{ route('product.watchesshow', ['product' => 4]) }}" class="block">
                <div class="aspect-square bg-black flex items-center justify-center p-8">
                    <img src="{{ asset('images/watches4.jpg') }}" alt="Tourbillon Prestige" class="w-full h-full object-contain">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">TIMEVA</p>
                    <h4 class="text-lg font-semibold mb-2">Tourbillon Prestige</h4>
                    <p class="text-xl font-bold mb-3">8900.00 €</p>
                    <div class="flex gap-2">
                        <span class="w-5 h-5 rounded-full bg-yellow-400 border-2 border-gray-300 cursor-pointer"></span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection