@extends('layout.pro')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-16 text-center">

    <div class="mb-8">
        <svg class="w-16 h-16 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <h1 class="text-3xl font-bold text-gray-900 mb-2">Commande confirmée !</h1>
    <p class="text-gray-500 mb-8">Merci pour votre achat. Un email de confirmation vous a été envoyé.</p>

    <div class="bg-gray-50 rounded-lg p-6 text-left mb-8">
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span>Référence</span>
            <span class="font-semibold text-gray-900">{{ $order->reference }}</span>
        </div>
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span>Date</span>
            <span>{{ $order->created_at->format('d/m/Y à H:i') }}</span>
        </div>
        <div class="flex justify-between text-sm text-gray-600 mb-4">
            <span>Statut</span>
            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                {{ ucfirst(str_replace('_', ' ', $order->statut)) }}
            </span>
        </div>

        <div class="border-t pt-4 mt-4">
            <h3 class="font-semibold text-gray-900 mb-3">Articles commandés</h3>
            @foreach($order->articles as $article)
                <div class="flex justify-between text-sm py-2 border-b border-gray-100 last:border-0">
                    <div>
                        <span class="font-medium">{{ $article->nom_produit }}</span>
                        @if(!empty($article->infos_variante['couleur']))
                            <span class="text-gray-400 ml-1">— {{ $article->infos_variante['couleur'] }}</span>
                        @endif
                        <span class="text-gray-400 ml-1">× {{ $article->quantite }}</span>
                    </div>
                    <span>{{ number_format($article->total, 2) }} €</span>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between font-bold text-lg mt-4 pt-4 border-t">
            <span>Total</span>
            <span>{{ number_format($order->montant, 2) }} €</span>
        </div>
    </div>

    <div class="flex gap-4 justify-center">
        <a href="{{ route('profile.orders') }}"
           class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition">
            Voir mes commandes
        </a>
        <a href="{{ route('home') }}"
           class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition">
            Continuer mes achats
        </a>
    </div>
</div>
@endsection
