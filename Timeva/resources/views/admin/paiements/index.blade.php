@extends('admin.layout')

@section('title', 'Historique des Paiements')
@section('page-title', 'Historique des Paiements')

@section('content')
<div class="py-6 space-y-6">

    {{-- Cards résumé --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-green-50 border border-green-200 rounded-xl px-5 py-4">
            <p class="text-xs font-medium text-green-700 mb-1">Chiffre d'affaires (payé)</p>
            <p class="text-2xl font-bold text-green-800">{{ number_format($totaux['paye'], 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-xl px-5 py-4">
            <p class="text-xs font-medium text-gray-600 mb-1">En attente de paiement</p>
            <p class="text-2xl font-bold text-gray-800">{{ $totaux['non_paye'] }}</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl px-5 py-4">
            <p class="text-xs font-medium text-red-700 mb-1">Paiements échoués</p>
            <p class="text-2xl font-bold text-red-800">{{ $totaux['echec'] }}</p>
        </div>
        <div class="bg-orange-50 border border-orange-200 rounded-xl px-5 py-4">
            <p class="text-xs font-medium text-orange-700 mb-1">Remboursements</p>
            <p class="text-2xl font-bold text-orange-800">{{ number_format($totaux['rembourse'], 0, ',', ' ') }} FCFA</p>
        </div>
    </div>

    {{-- Filtres --}}
    <form method="GET" class="flex gap-3">
        <select name="paiement_statut"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <option value="">Tous les statuts</option>
            <option value="paye"      {{ request('paiement_statut') === 'paye'      ? 'selected' : '' }}>Payé</option>
            <option value="non_paye"  {{ request('paiement_statut') === 'non_paye'  ? 'selected' : '' }}>Non payé</option>
            <option value="echec"     {{ request('paiement_statut') === 'echec'     ? 'selected' : '' }}>Échec</option>
            <option value="rembourse" {{ request('paiement_statut') === 'rembourse' ? 'selected' : '' }}>Remboursé</option>
        </select>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Référence de commande..."
               class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-gray-900">
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium">Filtrer</button>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-left text-xs text-gray-500 uppercase tracking-wide bg-gray-50">
                    <th class="px-6 py-3">Référence</th>
                    <th class="px-6 py-3">Client</th>
                    <th class="px-6 py-3">Montant</th>
                    <th class="px-6 py-3">Statut paiement</th>
                    <th class="px-6 py-3">ID FedaPay</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($paiements as $commande)
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
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $paiementClasses[$commande->paiement_statut ?? 'non_paye'] }}">
                            {{ $paiementLabels[$commande->paiement_statut ?? 'non_paye'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-mono text-xs text-gray-500">
                        {{ $commande->fedapay_transaction_id ?? '—' }}
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
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">Aucun paiement enregistré.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($paiements->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $paiements->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
