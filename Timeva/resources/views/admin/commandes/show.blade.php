@extends('admin.layout')

@section('title', 'Commande ' . $commande->reference)
@section('page-title', 'Commande ' . $commande->reference)

@section('content')
<div class="py-6 max-w-4xl space-y-6">

    <a href="{{ route('admin.commandes.index') }}" class="text-sm text-gray-500 hover:text-gray-900">← Retour aux commandes</a>

    <div class="grid grid-cols-3 gap-6">

        {{-- ===== DÉTAILS COMMANDE ===== --}}
        <div class="col-span-2 space-y-6">

            {{-- Articles --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">Articles commandés</h2>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 uppercase border-b border-gray-100 bg-gray-50">
                            <th class="px-6 py-3">Produit</th>
                            <th class="px-6 py-3">Variante</th>
                            <th class="px-6 py-3">Qté</th>
                            <th class="px-6 py-3">Prix unit.</th>
                            <th class="px-6 py-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($commande->articles as $article)
                        @php
                            $infos = is_array($article->infos_variante)
                                ? $article->infos_variante
                                : json_decode($article->infos_variante, true);
                        @endphp
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $article->nom_produit }}</td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $infos['couleur'] ?? '' }} {{ $infos['taille'] ?? '' }}
                            </td>
                            <td class="px-6 py-4">{{ $article->quantite }}</td>
                            <td class="px-6 py-4">{{ number_format($article->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                            <td class="px-6 py-4 text-right font-semibold">{{ number_format($article->total, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t border-gray-200 bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-6 py-4 font-bold text-gray-900 text-right">Total</td>
                            <td class="px-6 py-4 font-bold text-gray-900 text-right text-base">
                                {{ number_format($commande->montant, 0, ',', ' ') }} FCFA
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Adresse de livraison --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="font-semibold text-gray-900 mb-3">Adresse de livraison</h2>
                <p class="text-sm text-gray-700">{{ $commande->adresse_livraison }}</p>
                <p class="text-sm text-gray-700">{{ $commande->code_postal }} — {{ $commande->pays_expedition }}</p>
            </div>
        </div>

        {{-- ===== SIDEBAR DROITE ===== --}}
        <div class="space-y-5">

            {{-- Infos client --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Client</h3>
                <p class="text-sm font-medium text-gray-900">{{ $commande->user?->nom }} {{ $commande->user?->prenom }}</p>
                <p class="text-sm text-gray-500">{{ $commande->user?->email }}</p>
                <p class="text-xs text-gray-400 mt-1">Commande du {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
            </div>

            {{-- Statut paiement --}}
            @php
                $paiementLabels = [
                    'paye'      => ['label' => 'Payé', 'class' => 'bg-green-50 text-green-700 border-green-200'],
                    'non_paye'  => ['label' => 'Non payé', 'class' => 'bg-gray-50 text-gray-600 border-gray-200'],
                    'echec'     => ['label' => 'Échec paiement', 'class' => 'bg-red-50 text-red-700 border-red-200'],
                    'rembourse' => ['label' => 'Remboursé', 'class' => 'bg-orange-50 text-orange-700 border-orange-200'],
                ];
                $paiement = $paiementLabels[$commande->paiement_statut ?? 'non_paye'] ?? ['label' => '-', 'class' => 'bg-gray-50 text-gray-600 border-gray-200'];
            @endphp
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Paiement FedaPay</h3>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium border {{ $paiement['class'] }}">
                    {{ $paiement['label'] }}
                </span>
                @if($commande->fedapay_transaction_id)
                <p class="text-xs text-gray-400 mt-2 font-mono">ID : {{ $commande->fedapay_transaction_id }}</p>
                @endif
            </div>

            {{-- Changer le statut de la commande --}}
            @php
                $statutClasses = [
                    'en_attente' => 'bg-yellow-100 text-yellow-700',
                    'confirmé'   => 'bg-blue-100 text-blue-700',
                    'expédié'    => 'bg-purple-100 text-purple-700',
                    'livré'      => 'bg-green-100 text-green-700',
                    'annulé'     => 'bg-red-100 text-red-700',
                ];
            @endphp
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-2">Statut commande</h3>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $statutClasses[$commande->statut] ?? 'bg-gray-100 text-gray-600' }} mb-4">
                    {{ $statusLabels[$commande->statut] ?? ucfirst($commande->statut) }}
                </span>

                <form method="POST" action="{{ route('admin.commandes.updateStatut', $commande) }}">
                    @csrf @method('PATCH')
                    <select name="statut"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 mb-3">
                        @foreach($statusLabels as $key => $label)
                        <option value="{{ $key }}" {{ $commande->statut === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                            class="w-full bg-gray-900 text-white py-2 rounded-lg text-sm font-medium hover:bg-black transition-colors">
                        Mettre à jour
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection
