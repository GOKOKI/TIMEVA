<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // ... tes autres méthodes existantes ...

    public function profile()
    {
        return view('profile.index');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
        ]);

        Auth::user()->update($validated);

        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès !');
    }

    public function orders()
    {
        return view('profile.orders');
    }
}