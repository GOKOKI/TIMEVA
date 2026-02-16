@extends('layout.app')

@section('title', 'Connexion')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <section class="w-full max-w-md bg-white rounded-2xl shadow-md p-8">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-2">Connexion</h2>
        <p class="text-center text-gray-500 mb-6">Connectez-vous à votre compte <span class="font-semibold">Timeva</span>.</p>
        
        {{-- Messages d'erreur --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-600">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Message de succès (ex: après déconnexion) --}}
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm text-green-600">{{ session('success') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            
            <div class="flex flex-col">
                <label for="email" class="text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       required 
                       autofocus 
                       placeholder="votre@email.com"
                       class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900
                              @error('email') border-red-500 @else border-gray-300 @enderror">
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col">
                <label for="password" class="text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required
                       class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900
                              @error('password') border-red-500 @else border-gray-300 @enderror">
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Option "Se souvenir de moi" --}}
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                    <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                </label>
                
                {{-- Lien mot de passe oublié --}}
                <a href="#" class="text-sm text-gray-600 hover:text-gray-900 hover:underline">
                    Mot de passe oublié ?
                </a>
            </div>

            <div>
                <button type="submit"
                        class="w-full mt-2 bg-gray-900 text-white py-2.5 rounded-lg font-semibold hover:bg-gray-800 transition">
                    Se connecter
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            <p>Pas encore de compte ? 
                <a href="{{ route('register') }}" class="font-semibold text-gray-900 hover:underline">
                    Inscrivez-vous ici
                </a>
            </p>
        </div>
    </section>
</div>
@endsection