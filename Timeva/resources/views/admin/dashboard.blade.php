@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="py-6 space-y-8">

    {{-- ===== STATS CARDS ===== --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        @php
            $cards = [
                ['label' => 'Total commandes',  'value' => $stats['total_commandes'],    'color' => 'bg-gray-900 text-white'],
                ['label' => 'En cours',          'value' => $stats['commandes_en_cours'], 'color' => 'bg-yellow-50 text-yellow-800 border border-yellow-200'],
                ['label' => 'Livrées',           'value' => $stats['commandes_livrees'],  'color' => 'bg-green-50 text-green-800 border border-green-200'],
                ['label' => 'Produits',          'value' => $stats['total_produits'],     'color' => 'bg-blue-50 text-blue-800 border border-blue-200'],
                ['label' => 'Clients',           'value' => $stats['total_clients'],      'color' => 'bg-purple-50 text-purple-800 border border-purple-200'],
                ['label' => 'CA (payé)',         'value' => number_format($stats['chiffre_affaires'], 0, ',', ' ') . ' FCFA', 'color' => 'bg-emerald-50 text-emerald-800 border border-emerald-200'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="rounded-xl px-5 py-4 {{ $card['color'] }}">
            <p class="text-xs font-medium opacity-70 mb-1">{{ $card['label'] }}</p>
            <p class="text-2xl font-bold">{{ $card['value'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- ===== DERNIÈRES COMMANDES ===== --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Dernières commandes</h2>
            <a href="{{ route('admin.commandes.index') }}" class="text-sm text-gray-500 hover:text-gray-900">
                Voir toutes →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 text-left text-xs text-gray-500 uppercase tracking-wide">
                        <th class="px-6 py-3">Référence</th>
                        <th class="px-6 py-3">Client</th>
                        <th class="px-6 py-3">Montant</th>
                        <th class="px-6 py-3">Statut</th>
                        <th class="px-6 py-3">Paiement</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($dernieres_commandes as $commande)
                    @php
                        $statutClasses = [
                            'en_attente' => 'bg-yellow-100 text-yellow-700',
                            'confirmé'   => 'bg-blue-100 text-blue-700',
                            'expédié'    => 'bg-purple-100 text-purple-700',
                            'livré'      => 'bg-green-100 text-green-700',
                            'annulé'     => 'bg-red-100 text-red-700',
                        ];
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
                        <td class="px-6 py-4">{{ $commande->user?->nom }} {{ $commande->user?->prenom }}</td>
                        <td class="px-6 py-4 font-semibold">{{ number_format($commande->montant, 0, ',', ' ') }} FCFA</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statutClasses[$commande->statut] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($commande->statut) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $paiementClasses[$commande->paiement_statut ?? 'non_paye'] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $paiementLabels[$commande->paiement_statut ?? 'non_paye'] ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.commandes.show', $commande) }}" class="text-gray-500 hover:text-gray-900 text-xs">
                                Détails →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">Aucune commande</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
