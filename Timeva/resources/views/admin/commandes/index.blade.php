@extends('admin.layout')

@section('title', 'Commandes')
@section('page-title', 'Gestion des Commandes')

@section('content')
<div class="py-6 space-y-6">

    {{-- Filtres onglets --}}
    @php
        $tabs = [
            'all'        => ['label' => 'Toutes',    'count' => $counts['all']],
            'en_attente' => ['label' => 'En attente', 'count' => $counts['en_attente']],
            'confirmé'   => ['label' => 'Confirmées', 'count' => $counts['confirmé']],
            'expédié'    => ['label' => 'Expédiées',  'count' => $counts['expédié']],
            'livré'      => ['label' => 'Livrées',    'count' => $counts['livré']],
            'annulé'     => ['label' => 'Annulées',   'count' => $counts['annulé']],
        ];
        $statusClasses = [
            'en_attente' => 'bg-yellow-100 text-yellow-700',
            'confirmé'   => 'bg-blue-100 text-blue-700',
            'expédié'    => 'bg-purple-100 text-purple-700',
            'livré'      => 'bg-green-100 text-green-700',
            'annulé'     => 'bg-red-100 text-red-700',
        ];
    @endphp

    <div class="flex items-center gap-1 border-b border-gray-200">
        @foreach($tabs as $key => $tab)
        <a href="{{ route('admin.commandes.index', array_merge(request()->except('statut', 'page'), ['statut' => $key])) }}"
           class="px-4 py-2.5 text-sm font-medium border-b-2 -mb-px transition-colors
                  {{ $statut === $key
                      ? 'border-gray-900 text-gray-900'
                      : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            {{ $tab['label'] }}
            <span class="ml-1 px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-600">{{ $tab['count'] }}</span>
        </a>
        @endforeach
    </div>

    {{-- Recherche --}}
    <form method="GET" class="flex gap-3">
        <input type="hidden" name="statut" value="{{ $statut }}">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Rechercher par référence..."
               class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-72 focus:outline-none focus:ring-2 focus:ring-gray-900">
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium">Rechercher</button>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-left text-xs text-gray-500 uppercase tracking-wide bg-gray-50">
                    <th class="px-6 py-3">Référence</th>
                    <th class="px-6 py-3">Client</th>
                    <th class="px-6 py-3">Montant</th>
                    <th class="px-6 py-3">Statut commande</th>
                    <th class="px-6 py-3">Paiement</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($commandes as $commande)
                @php
                    $paiementClasses = [
                        'paye'      => 'bg-green-100 text-green-700',
                        'non_paye'  => 'bg-gray-100 text-gray-600',
                        'echec'     => 'bg-red-100 text-red-700',
                        'rembourse' => 'bg-orange-100 text-orange-700',
                    ];
                    $paiementLabels = [
                        'paye'      => 'Payé',
                        'non_paye'  => 'Non payé',
                        'echec'     => 'Échec',
                        'rembourse' => 'Remboursé',
                    ];
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-mono text-xs font-medium">{{ $commande->reference }}</td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $commande->user?->nom }} {{ $commande->user?->prenom }}</p>
                        <p class="text-xs text-gray-500">{{ $commande->user?->email }}</p>
                    </td>
                    <td class="px-6 py-4 font-semibold">{{ number_format($commande->montant, 0, ',', ' ') }} FCFA</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$commande->statut] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $tabs[$commande->statut]['label'] ?? ucfirst($commande->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $paiementClasses[$commande->paiement_statut ?? 'non_paye'] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $paiementLabels[$commande->paiement_statut ?? 'non_paye'] ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.commandes.show', $commande) }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                            Détails →
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">Aucune commande pour ce filtre.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($commandes->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $commandes->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
