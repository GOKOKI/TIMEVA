@extends('layout.pro')
@section('title', 'Mon compte')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8">Mon compte</h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1">
            <nav class="bg-gray-50 rounded-lg overflow-hidden">
                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-6 py-4 bg-gray-100 border-l-4 border-black font-medium">
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

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Prénom et Nom -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="firstname" class="block text-sm font-medium mb-2">Prénom</label>
                            <input 
                                type="text" 
                                id="firstname" 
                                name="firstname" 
                                value="Thierry"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                            >
                        </div>
                        <div>
                            <label for="lastname" class="block text-sm font-medium mb-2">Nom</label>
                            <input 
                                type="text" 
                                id="lastname" 
                                name="lastname" 
                                value="YERIMA"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                            >
                        </div>
                    </div>

                    <!-- Téléphone -->
                    <div class="mb-6">
                        <label for="phone" class="block text-sm font-medium mb-2">Téléphone</label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            value="0167469353"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                        >
                    </div>

                    <!-- Adresse -->
                    <div class="mb-6">
                        <label for="address" class="block text-sm font-medium mb-2">Adresse</label>
                        <input 
                            type="text" 
                            id="address" 
                            name="address" 
                            value="Abomey-Calavi"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                        >
                    </div>

                    <!-- Ville et Code postal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="city" class="block text-sm font-medium mb-2">Ville</label>
                            <input 
                                type="text" 
                                id="city" 
                                name="city" 
                                value="Cotonou"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                            >
                        </div>
                        <div>
                            <label for="postal_code" class="block text-sm font-medium mb-2">Code postal</label>
                            <input 
                                type="text" 
                                id="postal_code" 
                                name="postal_code" 
                                value=""
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                            >
                        </div>
                    </div>

                    <!-- Bouton Enregistrer -->
                    <button 
                        type="submit" 
                        class="bg-gray-900 text-white px-8 py-3 rounded-lg hover:bg-black transition-colors font-medium"
                    >
                        Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection