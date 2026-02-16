@extends('layout.pro')
@section('title', 'Mon compte')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8">Mon compte</h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1">
            <nav class="bg-gray-50 rounded-lg overflow-hidden">
                {{-- CORRECTION ICI : route('profile.index') au lieu de route('profile') --}}
                <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-6 py-4 bg-gray-100 border-l-4 border-black font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Mon profil
                </a>
                <a href="{{ route('profile.orders') }}" class="flex items-center gap-3 px-6 py-4 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Mes commandes
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3">
            <div class="bg-white border border-gray-200 rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Informations personnelles</h2>

                {{-- Affichage des erreurs --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-600">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Message de succès --}}
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-600">{{ session('success') }}</p>
                    </div>
                @endif

                {{-- Formulaire avec données dynamiques du profil --}}
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Prénom et Nom -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="prenom" class="block text-sm font-medium mb-2">Prénom</label>
                            <input 
                                type="text" 
                                id="prenom" 
                                name="prenom" 
                                value="{{ old('prenom', $profil->prenom ?? Auth::user()->name ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent
                                       @error('prenom') border-red-500 @enderror"
                            >
                            @error('prenom')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="nom" class="block text-sm font-medium mb-2">Nom</label>
                            <input 
                                type="text" 
                                id="nom" 
                                name="nom" 
                                value="{{ old('nom', $profil->nom ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent
                                       @error('nom') border-red-500 @enderror"
                            >
                            @error('nom')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email (lecture seule) -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium mb-2">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            value="{{ Auth::user()->email }}"
                            readonly
                            class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg text-gray-600 cursor-not-allowed"
                        >
                        <p class="text-xs text-gray-500 mt-1">L'email ne peut pas être modifié</p>
                    </div>

                    <!-- Téléphone -->
                    <div class="mb-6">
                        <label for="tel" class="block text-sm font-medium mb-2">Téléphone</label>
                        <input 
                            type="tel" 
                            id="tel" 
                            name="tel" 
                            value="{{ old('tel', $profil->tel ?? '') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent
                                   @error('tel') border-red-500 @enderror"
                        >
                        @error('tel')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Adresse -->
                    <div class="mb-6">
                        <label for="adresse" class="block text-sm font-medium mb-2">Adresse</label>
                        <input 
                            type="text" 
                            id="adresse" 
                            name="adresse" 
                            value="{{ old('adresse', $profil->adresse ?? '') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent
                                   @error('adresse') border-red-500 @enderror"
                        >
                        @error('adresse')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ville et Code postal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="ville" class="block text-sm font-medium mb-2">Ville</label>
                            <input 
                                type="text" 
                                id="ville" 
                                name="ville" 
                                value="{{ old('ville', $profil->ville ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent
                                       @error('ville') border-red-500 @enderror"
                            >
                            @error('ville')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="code_postal" class="block text-sm font-medium mb-2">Code postal</label>
                            <input 
                                type="text" 
                                id="code_postal" 
                                name="code_postal" 
                                value="{{ old('code_postal', $profil->code_postal ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent
                                       @error('code_postal') border-red-500 @enderror"
                            >
                            @error('code_postal')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Pays (champ caché ou modifiable) -->
                    <input type="hidden" name="pays" value="{{ old('pays', $profil->pays ?? 'France') }}">

                    <!-- Bouton Enregistrer -->
                    <button 
                        type="submit" 
                        class="bg-gray-900 text-white px-8 py-3 rounded-lg hover:bg-black transition-colors font-medium"
                    >
                        Enregistrer
                    </button>
                </form>

                {{-- Section changement de mot de passe --}}
                {{-- <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-xl font-bold mb-4">Changer de mot de passe</h3>
                    
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium mb-2">Mot de passe actuel</label>
                                <input 
                                    type="password" 
                                    id="current_password" 
                                    name="current_password" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                                    required
                                >
                            </div>
                            <div></div>
                            
                            <div>
                                <label for="new_password" class="block text-sm font-medium mb-2">Nouveau mot de passe</label>
                                <input 
                                    type="password" 
                                    id="new_password" 
                                    name="new_password" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                                    required
                                >
                            </div>
                            
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium mb-2">Confirmer</label>
                                <input 
                                    type="password" 
                                    id="new_password_confirmation" 
                                    name="new_password_confirmation" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                                    required
                                >
                            </div>
                        </div>
                        
                        <button type="submit" class="mt-4 bg-gray-200 text-gray-900 px-8 py-3 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                            Mettre à jour le mot de passe
                        </button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection