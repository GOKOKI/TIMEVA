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
        <!-- Produit 1 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
            <a href="{{ route('product.glassesshow', ['product' => 1]) }}" class="block">
                <div class="aspect-square bg-gray-100 flex items-center justify-center p-8">
                    <img src="{{ asset('images/glasses1.jpg') }}" alt="Carree Minialiste" class="w-full h-full object-contain">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">TIMEVA GLASSES</p>
                    <h4 class="text-lg font-semibold mb-2">Carree Minialiste</h4>
                    <p class="text-xl font-bold mb-3">120.00 €</p>
                    <div class="flex gap-2">
                        <span class="w-5 h-5 rounded-full bg-black border-2 border-gray-300 cursor-pointer"></span>
                        <span class="w-5 h-5 rounded-full bg-amber-700 border-2 border-gray-300 cursor-pointer"></span>
                        <span class="w-5 h-5 rounded-full bg-gray-400 border-2 border-gray-300 cursor-pointer"></span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Produit 2 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
            <a href="{{ route('product.glassesshow', ['product' => 2]) }}" class="block">
                <div class="aspect-square bg-gray-100 flex items-center justify-center p-8">
                    <img src="{{ asset('images/glasses2.jpg') }}" alt="Aviateur Classique" class="w-full h-full object-contain">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">TIMEVA GLASSES</p>
                    <h4 class="text-lg font-semibold mb-2">Aviateur Classique</h4>
                    <p class="text-xl font-bold mb-3">150.00 €</p>
                    <div class="flex gap-2">
                        <span class="w-5 h-5 rounded-full bg-gray-800 border-2 border-gray-300 cursor-pointer"></span>
                        <span class="w-5 h-5 rounded-full bg-yellow-600 border-2 border-gray-300 cursor-pointer"></span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Produit 3 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
            <a href="{{ route('product.glassesshow', ['product' => 3]) }}" class="block">
                <div class="aspect-square bg-gray-100 flex items-center justify-center p-8">
                    <img src="{{ asset('images/glasses3.jpg') }}" alt="Ronde Vintage" class="w-full h-full object-contain">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">TIMEVA GLASSES</p>
                    <h4 class="text-lg font-semibold mb-2">Ronde Vintage</h4>
                    <p class="text-xl font-bold mb-3">135.00 €</p>
                    <div class="flex gap-2">
                        <span class="w-5 h-5 rounded-full bg-rose-300 border-2 border-gray-300 cursor-pointer"></span>
                        <span class="w-5 h-5 rounded-full bg-blue-300 border-2 border-gray-300 cursor-pointer"></span>
                        <span class="w-5 h-5 rounded-full bg-green-300 border-2 border-gray-300 cursor-pointer"></span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Produit 4 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
            <a href="{{ route('product.glassesshow', ['product' => 4]) }}" class="block">
                <div class="aspect-square bg-gray-100 flex items-center justify-center p-8">
                    <img src="{{ asset('images/glasses4.jpg') }}" alt="Sport Performance" class="w-full h-full object-contain">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">TIMEVA GLASSES</p>
                    <h4 class="text-lg font-semibold mb-2">Sport Performance</h4>
                    <p class="text-xl font-bold mb-3">180.00 €</p>
                    <div class="flex gap-2">
                        <span class="w-5 h-5 rounded-full bg-black border-2 border-gray-300 cursor-pointer"></span>
                        <span class="w-5 h-5 rounded-full bg-red-600 border-2 border-gray-300 cursor-pointer"></span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection