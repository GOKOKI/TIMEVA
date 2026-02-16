<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // AFFICHAGE DU FORMULAIRE D'INSCRIPTION
    public function showRegister()
    {
        return view('auth.register'); // ✅ Retourne la vue
    }

    // TRAITEMENT DE L'INSCRIPTION
    public function register(Request $request)
    {
        // 1. ✅ Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'prenom' => 'nullable|string|max:255',
            'nom' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'code_postal' => 'nullable|string|max:10',
            'pays' => 'nullable|string|max:100'
        ]);

        // 2. ✅ Création de l'utilisateur
        $user = User::create([
            'nom' => $validated['nom'],
            'prenom'=>$validated['prenom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 3. ✅ Création du profil associé
        Profil::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'prenom' => $validated['prenom'] ?? null,
            'nom' => $validated['nom'] ?? null,
            'tel' => $validated['tel'] ?? null,
            'adresse' => $validated['adresse'] ?? null,
            'ville' => $validated['ville'] ?? null,
            'code_postal' => $validated['code_postal'] ?? null,
            'pays' => $validated['pays'] ?? 'France',
            'role' => 'user',
            'date_creation' => now(),
            'date_modification' => now()
        ]);

        // 4. ✅ Connexion automatique
        Auth::login($user);

        // 5. ✅ Redirection avec message de succès
        return redirect()->route('home')->with('success', 'Inscription réussie !');
    }

    // AFFICHAGE DU FORMULAIRE DE CONNEXION
    public function showLogin()
    {
        return view('auth.login'); // ✅ Retourne la vue
    }

    // TRAITEMENT DE LA CONNEXION
    public function login(Request $request)
    {
        // 1. ✅ Validation des données
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. ✅ Tentative de connexion
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirection selon le rôle
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('home'))->with('success', 'Connexion réussie !');
        }

        // 3. ✅ Échec de connexion
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

    // DÉCONNEXION
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Déconnexion réussie.');
    }
}