<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    private array $statusLabels = [
        'en_attente' => 'En attente',
        'confirmé'   => 'Confirmée',
        'expédié'    => 'Expédiée',
        'livré'      => 'Livrée',
        'annulé'     => 'Annulée',
    ];

    public function index(Request $request)
    {
        $query = Commande::with('user')->orderByDesc('created_at');

        $statut = $request->get('statut', 'all');
        if ($statut !== 'all') {
            $query->where('statut', $statut);
        }

        if ($request->filled('search')) {
            $query->where('reference', 'like', '%' . $request->search . '%');
        }

        $commandes = $query->paginate(20)->withQueryString();

        $counts = [
            'all'        => Commande::count(),
            'en_attente' => Commande::where('statut', 'en_attente')->count(),
            'confirmé'   => Commande::where('statut', 'confirmé')->count(),
            'expédié'    => Commande::where('statut', 'expédié')->count(),
            'livré'      => Commande::where('statut', 'livré')->count(),
            'annulé'     => Commande::where('statut', 'annulé')->count(),
        ];

        $statusLabels = $this->statusLabels;

        return view('admin.commandes.index', compact('commandes', 'statut', 'counts', 'statusLabels'));
    }

    public function show(Commande $commande)
    {
        $commande->load(['user', 'articles']);
        $statusLabels = $this->statusLabels;

        return view('admin.commandes.show', compact('commande', 'statusLabels'));
    }

    public function updateStatut(Request $request, Commande $commande)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,confirmé,expédié,livré,annulé',
        ]);

        $commande->update(['statut' => $request->statut]);

        return redirect()->route('admin.commandes.show', $commande)
            ->with('success', 'Statut mis à jour : ' . ($this->statusLabels[$request->statut] ?? $request->statut));
    }
}
