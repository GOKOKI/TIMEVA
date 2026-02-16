<header class="bg-white border-b border-gray-200">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold">
                <span>TIMEVA</span>
            </a>

            <!-- Navigation centrale -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('products.watches') }}" class="text-gray-700 hover:text-black font-medium transition-colors">
                    Montres
                </a>
                <a href="{{ route('products.glasses') }}" class="text-gray-700 hover:text-black font-medium transition-colors">
                    Lunettes
                </a>
            </nav>

            <!-- Actions utilisateur - Version profil -->
            <div class="flex items-center gap-4">
                <!-- Panier -->
                <a href="{{ route('cart.index') }}" class="relative p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    @php
                        $cartCount = \App\Models\Panier::where('user_id', Auth::id())->sum('quantite');
                    @endphp
                    @if($cartCount > 0)
                    <span class="absolute -top-1 -right-1 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-medium">
                        {{ $cartCount }}
                    </span>
                    @endif
                </a>

                <!-- Menu utilisateur simplifié pour le profil -->
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600 hidden md:block">
                        {{ Auth::user()->name }}
                    </span>
                    
                    <!-- Bouton retour au site (optionnel) -->
                    <a href="{{ route('home') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors" title="Retour à l'accueil">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>