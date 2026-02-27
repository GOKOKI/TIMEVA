@extends('profile.layout')

@section('profile-content')
<div class="bg-white border border-gray-200 rounded-lg p-8">
    <div class="space-y-6">

        @forelse($commandes ?? [] as $commande)
        <!-- Commande -->
        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
            <!-- En-tête de commande -->
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-xl font-bold mb-1">Commande #{{ $commande->id_formatted ?? substr($commande->id, 0, 8) }}</h3>
                    <p class="text-sm text-gray-500">{{ $commande->date_creation->format('d F Y') }}</p>
                </div>
                
                {{-- Badge de statut dynamique --}}
                @php
                    $statusClasses = [
                        'en_attente' => 'bg-yellow-100 text-yellow-700',
                        'confirmé'   => 'bg-blue-100 text-blue-700',
                        'expédié'    => 'bg-purple-100 text-purple-700',
                        'livré'      => 'bg-green-100 text-green-700',
                        'annulé'     => 'bg-red-100 text-red-700',
                    ];
                    $statusClass = $statusClasses[$commande->statut] ?? 'bg-gray-100 text-gray-700';
                    $statusLabels = [
                        'en_attente' => 'En attente',
                        'confirmé'   => 'Confirmée',
                        'expédié'    => 'Expédiée',
                        'livré'      => 'Livrée',
                        'annulé'     => 'Annulée',
                    ];
                @endphp
                <span class="px-3 py-1 {{ $statusClass }} rounded-full text-sm font-medium">
                    {{ $statusLabels[$commande->statut] ?? ucfirst($commande->statut) }}
                </span>
            </div>

            <!-- Liste des produits -->
            <div class="space-y-2 mb-4">
                @foreach($commande->articles as $article)
                <div class="flex items-center justify-between">
                    <p class="text-gray-700">
                        {{ $article->nom_produit }} 
                        @if($article->infos_variante)
                            @php $infos = json_decode($article->infos_variante, true); @endphp
                            ({{ $infos['couleur'] ?? '' }} {{ $infos['taille'] ?? '' }})
                        @endif
                        × {{ $article->quantite }}
                    </p>
                    <p class="font-medium">{{ number_format($article->prix_unitaire * $article->quantite, 2) }} €</p>
                </div>
                @endforeach
            </div>

            <!-- Total et actions -->
            <div class="border-t border-gray-200 pt-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-lg font-bold">Total</p>
                    <p class="text-xl font-bold">{{ number_format($commande->montant, 2) }} €</p>
                </div>
                
                {{-- Actions selon le statut --}}
                <div class="flex gap-3">
                    <a href="{{ route('profile.orders.details', $commande->id) }}" 
                       class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                        Voir les détails →
                    </a>
                    
                    @if($commande->statut === 'en_attente')
                    <form action="{{ route('profile.orders.cancel', $commande) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium"
                                onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                            Annuler la commande
                        </button>
                    </form>
                    @endif
                    
                    @if($commande->statut === 'livré')
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                        Laisser un avis →
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <!-- Aucune commande -->
        <div class="text-center py-12">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Aucune commande</h3>
            <p class="text-gray-500 mb-6">Vous n'avez pas encore passé de commande.</p>
            <a href="{{ route('products.watches') }}" 
               class="inline-block bg-gray-900 text-white px-6 py-3 rounded-lg hover:bg-black transition-colors font-medium">
                Commencer mes achats
            </a>
        </div>
        @endforelse

        {{-- Pagination --}}
        @if(isset($commandes) && method_exists($commandes, 'links'))
        <div class="mt-6">
            {{ $commandes->links() }}
        </div>
        @endif

    </div>
</div>
@endsection