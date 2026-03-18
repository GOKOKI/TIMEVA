<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $query = Commande::with('user')
            ->whereNotNull('fedapay_transaction_id')
            ->orderByDesc('created_at');

        if ($request->filled('paiement_statut')) {
            $query->where('paiement_statut', $request->paiement_statut);
        }

        if ($request->filled('search')) {
            $query->where('reference', 'like', '%' . $request->search . '%');
        }

        $paiements = $query->paginate(20)->withQueryString();

        $totaux = [
            'paye'        => Commande::where('paiement_statut', 'paye')->sum('montant'),
            'non_paye'    => Commande::where('paiement_statut', 'non_paye')->count(),
            'echec'       => Commande::where('paiement_statut', 'echec')->count(),
            'rembourse'   => Commande::where('paiement_statut', 'rembourse')->sum('montant'),
        ];

        return view('admin.paiements.index', compact('paiements', 'totaux'));
    }
}
