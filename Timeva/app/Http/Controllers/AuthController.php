<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showRegister()
    {   
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    public function register(Request $request)
    {
        // logique d'inscription 
        return redirect()->route('login');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        return redirect()->route('home');
    }

    public function logout()
    {
        // logique de déconnexion
        return redirect()->route('home');
    }

    
}