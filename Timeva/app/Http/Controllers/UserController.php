<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Profil;
use App\Models\Commande;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $profil = $user->profil ?? new Profil(['user_id' => $user->id]);
        
        return view('profile.index', compact('profil'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'prenom' => 'nullable|string|max:255',
            'nom' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'code_postal' => 'nullable|string|max:10',
            'pays' => 'nullable|string|max:100'
        ]);

        $user = Auth::user();
        
    
        // On récupère le profil ou on en crée un nouveau avec un UUID
        $profil = $user->profil ?? new Profil([
            'user_id' => $user->id, 
            'id' => (string) Str::uuid()
        ]);

        $profil->fill($validated);
        
        $profil->save();

        return back()->with('success', 'Profil mis à jour avec succès');
    }

    public function orders()
    {
        $commandes = Auth::user()->commandes()->latest()->get();
        return view('profile.orders', compact('commandes'));
    }

    public function orderDetails(Commande $order)
    {
        $order->load('articles');
        return view('profile.order-details', compact('order'));
    }

    public function cancelOrder(Commande $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        abort_if($order->statut !== 'en_attente', 403, 'Cette commande ne peut plus être annulée.');

        $order->update(['statut' => 'annulé']);

        return back()->with('success', 'Commande annulée avec succès.');
    }
}