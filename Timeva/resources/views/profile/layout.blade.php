@extends('layout.pro')
@section('title', 'Mon compte')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8">Mon compte</h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation (toujours visible) -->
        <div class="lg:col-span-1">
            <nav class="bg-gray-50 rounded-lg overflow-hidden">
                <a href="{{ route('profile') }}" 
                   class="flex items-center gap-3 px-6 py-4 {{ request()->routeIs('profile') ? 'bg-gray-100 border-l-4 border-black font-medium' : 'hover:bg-gray-100' }} transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Mon profil
                </a>
                <a href="{{ route('profile.orders') }}" 
                   class="flex items-center gap-3 px-6 py-4 {{ request()->routeIs('profile.orders') ? 'bg-gray-100 border-l-4 border-black font-medium' : 'hover:bg-gray-100' }} transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Mes commandes
                </a>
            </nav>
        </div>

        <!-- Contenu dynamique (change selon la page) -->
        <div class="lg:col-span-3">
            @yield('profile-content')
        </div>
    </div>
</div>
@endsection