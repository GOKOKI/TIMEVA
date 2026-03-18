@extends('layout.app')

@section('title', 'Commande confirmée')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-2xl mx-auto text-center">

        {{-- Icône succès --}}
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-2">Paiement réussi !</h1>
        <p class="text-gray-500 mb-8">Merci pour votre achat. Un email de confirmation vous a été envoyé.</p>

        {{-- Récapitulatif commande --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 text-left mb-8">

            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Référence</span>
                <span class="font-semibold text-gray-900 font-mono">{{ $commande->reference }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Date</span>
                <span>{{ $commande->created_at->format('d/m/Y à H:i') }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-600 mb-4">
                <span>Statut</span>
                <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
                    Confirmée
                </span>
            </div>

            {{-- Articles --}}
            <div class="border-t border-gray-100 pt-4 mt-2">
                <h3 class="font-semibold text-gray-900 mb-3 text-sm">Articles commandés</h3>
                <div class="space-y-2">
                    @foreach($commande->articles as $article)
                    <div class="flex justify-between text-sm py-2 border-b border-gray-50 last:border-0">
                        <div>
                            <span class="font-medium text-gray-900">{{ $article->nom_produit }}</span>
                            @if(!empty($article->infos_variante['couleur']))
                            <span class="text-gray-400 ml-1">— {{ $article->infos_variante['couleur'] }}</span>
                            @endif
                            <span class="text-gray-400 ml-1">× {{ $article->quantite }}</span>
                        </div>
                        <span class="font-medium">{{ number_format($article->total, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Total --}}
            <div class="flex justify-between font-bold text-lg mt-4 pt-4 border-t border-gray-200">
                <span>Total payé</span>
                <span>{{ number_format($commande->montant, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>

        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('profile.orders') }}"
               class="bg-gray-900 text-white px-8 py-3 rounded-full hover:bg-black transition-colors font-medium">
                Voir mes commandes
            </a>
            <a href="{{ route('home') }}"
               class="border border-gray-300 text-gray-700 px-8 py-3 rounded-full hover:border-gray-900 hover:text-gray-900 transition-colors font-medium">
                Continuer mes achats
            </a>
        </div>

    </div>
</div>
@endsection
