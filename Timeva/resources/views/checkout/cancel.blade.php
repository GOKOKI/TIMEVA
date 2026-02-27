@extends('layout.pro')

@section('content')
<div class="max-w-xl mx-auto px-4 py-16 text-center">

    <div class="mb-8">
        <svg class="w-16 h-16 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <h1 class="text-3xl font-bold text-gray-900 mb-2">Paiement annulé</h1>
    <p class="text-gray-500 mb-8">Votre commande n'a pas été finalisée. Votre panier est toujours disponible.</p>

    <div class="flex gap-4 justify-center">
        <a href="{{ route('checkout.index') }}"
           class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition">
            Réessayer
        </a>
        <a href="{{ route('cart.index') }}"
           class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition">
            Retour au panier
        </a>
    </div>
</div>
@endsection
