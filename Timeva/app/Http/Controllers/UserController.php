<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // ... tes autres méthodes existantes ...

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
        
        $profil = $user->profil ?? new Profil(['user_id' => $user->id, 'id' => Str::uuid()]);
        
        $profil->fill($validated);
        $profil->date_modification = now();
        $profil->save();

        return back()->with('success', 'Profil mis à jour avec succès');
    }

    public function orders()
    {
        return view('profile.orders');
    }
}