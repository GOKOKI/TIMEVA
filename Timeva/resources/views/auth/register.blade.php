@extends('layout.app')

@section('title', 'Inscription')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-md p-8">

        <!-- Titre -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Inscription</h2>
            <p class="text-gray-500 mt-1">Créez votre compte <span class="font-semibold">Timeva</span></p>
        </div>

        <!-- Messages d'erreur -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-600">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Formulaire -->
        <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
            @csrf

            <!-- Nom -->
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">
                    Nom
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Jean"
                    required
                    class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900
                           @error('name') border-red-500 @else border-gray-300 @enderror"
                >
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!--Prenom-->
            <div>
                <label for="Prenom" class="block text-sm font-medium text-gray-700 mb-1">
                    Prenom
                </label>
                <input
                    type="text"
                    id="Prenom"
                    name="Prenom"
                    value="{{ old('Prenom') }}"
                    placeholder="Dupont"
                    required
                    class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900
                           @error('Prenom') border-red-500 @else border-gray-300 @enderror"
                >
                @error('Prenom')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="votre@email.com"
                    required
                    class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900
                           @error('email') border-red-500 @else border-gray-300 @enderror"
                >
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Mot de passe
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900
                           @error('password') border-red-500 @else border-gray-300 @enderror"
                >
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Confirmer le mot de passe
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900"
                >
            </div>

            <!-- Bouton -->
            <button
                type="submit"
                class="w-full mt-4 bg-gray-900 text-white py-2.5 rounded-lg font-semibold hover:bg-gray-800 transition"
            >
                S'inscrire
            </button>
        </form>

        <!-- Lien connexion -->
        <p class="text-center text-sm text-gray-600 mt-6">
            Déjà un compte ?
            <a href="{{ route('login') }}" class="font-semibold text-gray-900 hover:underline">
                Se connecter
            </a>
        </p>
    </div>
</div>
@endsection