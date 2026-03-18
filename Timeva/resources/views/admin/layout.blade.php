<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — TIMEVA</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen" x-data="{ sidebarOpen: true }">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-64 bg-gray-900 text-white flex flex-col shrink-0">
        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-gray-700">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold tracking-widest">TIMEVA</a>
            <p class="text-xs text-gray-400 mt-0.5">Panel Administrateur</p>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-6 space-y-1">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard',        'label' => 'Dashboard',    'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['route' => 'admin.products.index',   'label' => 'Produits',     'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                    ['route' => 'admin.commandes.index',  'label' => 'Commandes',    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ['route' => 'admin.paiements.index',  'label' => 'Paiements',    'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                ];
            @endphp

            @foreach($navItems as $item)
            @php $active = request()->routeIs(str_replace('.index', '.*', $item['route'])); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ $active ? 'bg-white text-gray-900' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                </svg>
                {{ $item['label'] }}
            </a>
            @endforeach
        </nav>

        {{-- Bas de sidebar --}}
        <div class="px-4 py-4 border-t border-gray-700">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xs text-gray-400 hover:text-white mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voir le site
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left text-xs text-gray-400 hover:text-red-400 transition-colors">
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== CONTENU PRINCIPAL ===== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Header --}}
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->nom }}</p>
                    <p class="text-xs text-gray-500">Administrateur</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Flash messages --}}
        <div class="px-8 pt-4">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm mb-4">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm mb-4">
                {{ session('error') }}
            </div>
            @endif
        </div>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto px-8 pb-8">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
