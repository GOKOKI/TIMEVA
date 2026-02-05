@extends('layout.app')
@section('title', 'Chronographe Royal')
@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Bouton Retour -->
    <a href="{{ route('products.watches') }}" class="inline-flex items-center gap-2 text-gray-700 hover:text-black mb-8">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        <span class="font-medium">Retour</span>
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Image du produit -->
        <div class="bg-gray-200 rounded-2xl overflow-hidden aspect-square flex items-center justify-center p-12">
            <img src="{{ asset('images/watches1.jpg') }}" alt="Chronographe Royal" class="w-full h-full object-contain">
        </div>

        <!-- Détails du produit -->
        <div class="flex flex-col">
            <p class="text-xs text-gray-500 uppercase tracking-widest mb-3">ÉLÉGANCE</p>
            <h1 class="text-4xl lg:text-5xl font-bold mb-6">Chronographe Royal</h1>
            <p class="text-3xl font-bold mb-6">2350.00 €</p>
            
            <p class="text-gray-600 mb-8 leading-relaxed">
                Montre chronographe automatique avec boîtier en acier inoxydable et bracelet en cuir véritable. Mouvement suisse de haute précision.
            </p>

            <!-- Couleur -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Couleur</h3>
                <div class="flex gap-3">
                    <button class="w-12 h-12 rounded-full bg-gray-300 border-2 border-gray-400 hover:border-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400"></button>
                    <button class="w-12 h-12 rounded-full bg-black border-2 border-black hover:border-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800"></button>
                    <button class="w-12 h-12 rounded-full bg-gray-400 border-2 border-gray-500 hover:border-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"></button>
                </div>
            </div>

            <!-- Taille -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Taille</h3>
                <div class="flex gap-3">
                    <button class="px-6 py-3 border-2 border-gray-300 rounded-lg hover:border-gray-400 transition-colors font-medium">
                        42mm
                    </button>
                    <button class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-black transition-colors font-medium">
                        38mm
                    </button>
                </div>
            </div>

            <!-- Stock -->
            <p class="text-sm text-gray-700 mb-6">3 en stock</p>

            <!-- Quantité -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Quantité</h3>
                <div class="flex items-center gap-4">
                    <button class="w-12 h-12 border-2 border-gray-300 rounded-lg hover:border-gray-400 transition-colors flex items-center justify-center font-medium text-xl">
                        −
                    </button>
                    <span class="text-xl font-medium w-12 text-center">1</span>
                    <button class="w-12 h-12 border-2 border-gray-300 rounded-lg hover:border-gray-400 transition-colors flex items-center justify-center font-medium text-xl">
                        +
                    </button>
                </div>
            </div>

            <!-- Bouton Ajouter au panier -->
            <button class="w-full bg-gray-900 text-white py-4 rounded-lg hover:bg-black transition-colors font-medium text-lg flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Ajouter au panier
            </button>
        </div>
    </div>
</div>
@endsection