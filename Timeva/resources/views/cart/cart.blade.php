@extends('layout.pro')
@section('title', 'Votre panier')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8">Votre panier</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Liste des articles -->
        <div class="lg:col-span-2 space-y-3">
            
            <!-- Article 1 -->
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <div class="flex gap-4">
                    <!-- Image produit -->
                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 flex items-center justify-center p-2">
                        <img src="{{ asset('images/glasses1.jpg') }}" alt="Cat Eye Élégance" class="w-full h-full object-contain">
                    </div>

                    <!-- Informations produit -->
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-1">
                            <div>
                                <h3 class="text-lg font-bold mb-0.5">Cat Eye Élégance</h3>
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">ÉLÉGANCE</p>
                                <p class="text-xs text-gray-600 mb-2">Couleur: #1a1a1a • Taille: Standard</p>
                            </div>

                            <!-- Bouton supprimer -->
                            <button class="text-red-500 hover:text-red-700 transition-colors p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Prix + Quantité alignée à droite -->
                        <div class="flex items-center mt-2">
                            <p class="text-lg font-bold">280.00 €</p>

                            <div class="flex items-center gap-2 ml-auto">
                                <button class="w-8 h-8 border border-gray-300 rounded-lg hover:border-gray-400 transition-colors flex items-center justify-center">
                                    <span class="text-sm font-medium">−</span>
                                </button>
                                <span class="text-sm font-medium w-6 text-center">3</span>
                                <button class="w-8 h-8 border border-gray-300 rounded-lg hover:border-gray-400 transition-colors flex items-center justify-center">
                                    <span class="text-sm font-medium">+</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Article 2 -->
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <div class="flex gap-4">
                    <!-- Image produit -->
                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 flex items-center justify-center p-2">
                        <img src="{{ asset('images/glasses2.jpg') }}" alt="Carré Minimaliste" class="w-full h-full object-contain">
                    </div>

                    <!-- Informations produit -->
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-1">
                            <div>
                                <h3 class="text-lg font-bold mb-0.5">Carré Minimaliste</h3>
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">ÉLÉGANCE</p>
                                <p class="text-xs text-gray-600 mb-2">Couleur: #C0C0C0 • Taille: Standard</p>
                            </div>

                            <!-- Bouton supprimer -->
                            <button class="text-red-500 hover:text-red-700 transition-colors p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Prix + Quantité alignée à droite -->
                        <div class="flex items-center mt-2">
                            <p class="text-lg font-bold">245.00 €</p>

                            <div class="flex items-center gap-2 ml-auto">
                                <button class="w-8 h-8 border border-gray-300 rounded-lg hover:border-gray-400 transition-colors flex items-center justify-center">
                                    <span class="text-sm font-medium">−</span>
                                </button>
                                <span class="text-sm font-medium w-6 text-center">1</span>
                                <button class="w-8 h-8 border border-gray-300 rounded-lg hover:border-gray-400 transition-colors flex items-center justify-center">
                                    <span class="text-sm font-medium">+</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Récapitulatif -->
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-200 rounded-lg p-6 sticky top-4">
                <h2 class="text-2xl font-bold mb-6">Récapitulatif</h2>

                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600">Sous-total</span>
                    <span class="font-medium">1085.00 €</span>
                </div>

                <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200">
                    <span class="text-gray-600">Livraison</span>
                    <span class="font-medium">Gratuite</span>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <span class="text-xl font-bold">Total</span>
                    <span class="text-2xl font-bold">1085.00 €</span>
                </div>

                <a href="{{ route('checkout') }}" class="w-full bg-gray-900 text-white py-4 rounded-lg hover:bg-black transition-colors font-medium mb-4 flex items-center justify-center gap-2">
                    Commander
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>

                <a href="{{ route('home') }}" class="block text-center text-gray-700 hover:text-black font-medium transition-colors">
                    Continuer mes achats
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
