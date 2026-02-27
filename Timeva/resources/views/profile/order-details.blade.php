@extends('profile.layout')

@section('profile-content')
<div class="bg-white border border-gray-200 rounded-lg p-8">

    {{-- En-tête --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold mb-1">Commande #{{ substr($order->id, 0, 8) }}</h2>
            <p class="text-sm text-gray-500">{{ $order->created_at->format('d F Y') }}</p>
        </div>

        @php
            $statusClasses = [
                'en_attente' => 'bg-yellow-100 text-yellow-700',
                'confirmé'   => 'bg-blue-100 text-blue-700',
                'expédié'    => 'bg-purple-100 text-purple-700',
                'livré'      => 'bg-green-100 text-green-700',
                'annulé'     => 'bg-red-100 text-red-700',
            ];
            $statusLabels = [
                'en_attente' => 'En attente',
                'confirmé'   => 'Confirmée',
                'expédié'    => 'Expédiée',
                'livré'      => 'Livrée',
                'annulé'     => 'Annulée',
            ];
            $statusClass = $statusClasses[$order->statut] ?? 'bg-gray-100 text-gray-700';
        @endphp
        <span class="px-3 py-1 {{ $statusClass }} rounded-full text-sm font-medium">
            {{ $statusLabels[$order->statut] ?? ucfirst($order->statut) }}
        </span>
    </div>

    {{-- Adresse de livraison --}}
    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="font-semibold mb-2">Adresse de livraison</h3>
        <p class="text-gray-700">{{ $order->adresse_livraison }}</p>
        <p class="text-gray-700">{{ $order->code_postal }} — {{ $order->pays_expedition }}</p>
    </div>

    {{-- Articles --}}
    <div class="space-y-4 mb-6">
        <h3 class="font-semibold">Articles</h3>
        @foreach($order->articles as $article)
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <div>
                <p class="font-medium">{{ $article->nom_produit }}</p>
                @if($article->infos_variante)
                    @php $infos = is_array($article->infos_variante) ? $article->infos_variante : json_decode($article->infos_variante, true); @endphp
                    <p class="text-sm text-gray-500">
                        {{ $infos['couleur'] ?? '' }} {{ $infos['taille'] ?? '' }}
                    </p>
                @endif
                <p class="text-sm text-gray-500">Qté : {{ $article->quantite }}</p>
            </div>
            <p class="font-medium">{{ number_format($article->prix_unitaire * $article->quantite, 2) }} €</p>
        </div>
        @endforeach
    </div>

    {{-- Total --}}
    <div class="flex items-center justify-between border-t border-gray-200 pt-4 mb-6">
        <p class="text-lg font-bold">Total</p>
        <p class="text-xl font-bold">{{ number_format($order->montant, 2) }} €</p>
    </div>

    {{-- Actions --}}
    <div class="flex gap-4">
        <a href="{{ route('profile.orders') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
            ← Retour aux commandes
        </a>
    </div>

</div>
@endsection
