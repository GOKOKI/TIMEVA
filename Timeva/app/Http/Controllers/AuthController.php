<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'prenom'      => 'nullable|string|max:255',
            'nom'         => 'nullable|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users,email',
            'password'    => 'required|string|min:8|confirmed',
            'tel'         => 'nullable|string|max:20',
            'adresse'     => 'nullable|string|max:255',
            'ville'       => 'nullable|string|max:100',
            'code_postal' => 'nullable|string|max:10',
            'pays'        => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'prenom'   => $validated['prenom'] ?? null,
            'nom'      => $validated['nom'] ?? null,
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Inscription reussie !');
    }



    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $this->loadCartFromDb();

            $user = Auth::user();
            $user->load('profil');

            if ($user->is_admin) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Bienvenue sur le panneau d\'administration !');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Connexion reussie !');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }



    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Deconnexion reussie.');
    }



    /*
    |--------------------------------------------------------------------------
    | FORGOT PASSWORD
    |--------------------------------------------------------------------------
    */

    public function showForgot()
    {
        return view('auth.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        Password::sendResetLink($request->only('email'));

        return back()->with('status', 'Si cet email est associe a un compte, vous recevrez un lien de reinitialisation.');
    }



    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Mot de passe reinitialise avec succes !')
            : back()->withErrors(['email' => 'Echec de la reinitialisation.']);
    }



    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    private function loadCartFromDb(): void
    {
        $panierItems = Panier::with('variant.product')
            ->where('user_id', Auth::id())
            ->get();

        if ($panierItems->isEmpty()) {
            return;
        }

        $cart = Session::get('cart', []);

        foreach ($panierItems as $item) {
            $variantId = $item->variant_id;

            if (isset($cart[$variantId]) || !$item->variant || !$item->variant->product) {
                continue;
            }

            $variant = $item->variant;
            $cart[$variantId] = [
                'name'         => $variant->product->name,
                'variant_name' => trim(($variant->color ?? '') . ' ' . ($variant->size ?? '')),
                'price'        => $variant->product->prix,
                'quantity'     => $item->quantite,
                'image'        => $variant->image_url ?? $variant->product->image,
                'slug'         => $variant->product->slug,
            ];
        }

        Session::put('cart', $cart);
    }
}
