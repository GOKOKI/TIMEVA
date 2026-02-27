@extends('layout.pro')
@section('title', 'Votre panier')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8">Votre panier</h1>

    @if(isset($cartItems) && $cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Liste des articles -->
            <div class="lg:col-span-2 space-y-3">
                
                @foreach($cartItems as $item)
                <!-- Article -->
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex gap-4">
                        <!-- Image produit -->
                        <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 flex items-center justify-center p-2">
                            <img src="{{ $item->variante->image ?? asset('images/default-product.jpg') }}" 
                                 alt="{{ $item->variante->produit->nom }}" 
                                 class="w-full h-full object-contain">
                        </div>

                        <!-- Informations produit -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-1">
                                <div>
                                    <h3 class="text-lg font-bold mb-0.5">{{ $item->variante->produit->nom }}</h3>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ $item->variante->produit->marque }}</p>
                                    <p class="text-xs text-gray-600 mb-2">
                                        @if($item->variante->couleur) Couleur: {{ $item->variante->couleur }} • @endif
                                        @if($item->variante->taille) Taille: {{ $item->variante->taille }} @endif
                                    </p>
                                </div>

                                <!-- Formulaire supprimer -->
                                <form action="{{ route('cart.remove', $item->variante->id_variant) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Prix + Formulaire quantité -->
                            <div class="flex items-center mt-2">
                                <p class="text-lg font-bold">{{ number_format($item->variante->prix_final, 2) }} €</p>

                                <form action="{{ route('cart.update', $item->variante->id_variant) }}" method="POST" class="ml-auto flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="quantite" value="{{ $item->quantite - 1 }}" 
                                            class="w-8 h-8 border border-gray-300 rounded-lg hover:border-gray-400 transition-colors flex items-center justify-center"
                                            {{ $item->quantite <= 1 ? 'disabled' : '' }}>
                                        <span class="text-sm font-medium">−</span>
                                    </button>
                                    <span class="text-sm font-medium w-6 text-center">{{ $item->quantite }}</span>
                                    <button type="submit" name="quantite" value="{{ $item->quantite + 1 }}" 
                                            class="w-8 h-8 border border-gray-300 rounded-lg hover:border-gray-400 transition-colors flex items-center justify-center"
                                            {{ $item->quantite >= $item->variante->quantite_stock ? 'disabled' : '' }}>
                                        <span class="text-sm font-medium">+</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <!-- Récapitulatif -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-lg p-6 sticky top-4">
                    <h2 class="text-2xl font-bold mb-6">Récapitulatif</h2>

                    <div class="flex items-center justify-between mb-4">
                        <span class="text-gray-600">Sous-total</span>
                        <span class="font-medium">{{ number_format($total, 2) }} €</span>
                    </div>

                    <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200">
                        <span class="text-gray-600">Livraison</span>
                        <span class="font-medium">Gratuite</span>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <span class="text-xl font-bold">Total</span>
                        <span class="text-2xl font-bold">{{ number_format($total, 2) }} €</span>
                    </div>

                    {{-- CORRECTION ICI : route('checkout.index') au lieu de route('checkout') --}}
                    <a href="{{ route('checkout.index') }}" 
                       class="w-full bg-gray-900 text-white py-4 rounded-lg hover:bg-black transition-colors font-medium mb-4 flex items-center justify-center gap-2">
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
    @else
        <div class="text-center py-12">
            <div class="mb-4">
                <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Votre panier est vide</h2>
            <p class="text-gray-600 mb-6">Découvrez nos collections de montres et lunettes</p>
            <a href="{{ route('products.watches') }}" 
               class="inline-block bg-gray-900 text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors">
                Découvrir nos produits
            </a>
        </div>
    @endif
</div>
@endsection