<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_commandes'    => Commande::count(),
            'commandes_en_cours' => Commande::whereIn('statut', ['en_attente', 'confirmé', 'expédié'])->count(),
            'commandes_livrees'  => Commande::where('statut', 'livré')->count(),
            'chiffre_affaires'   => Commande::where('paiement_statut', 'paye')->sum('montant'),
            'total_produits'     => Product::count(),
            'total_clients'      => User::count(),
        ];

        $dernieres_commandes = Commande::with('user')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'dernieres_commandes'));
    }
}
