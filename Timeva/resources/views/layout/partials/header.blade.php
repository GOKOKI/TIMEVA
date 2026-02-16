<header class="fixed top-0 left-0 right-0 z-50">
    <nav class="navbar-dark">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 relative">

                <!-- LOGO TIMEVA STYLISÉ -->
                <a href="{{ route('home') }}" class="logo-timeva">
                    TIMEVA
                </a>

                <!-- MENU BURGER MOBILE -->
                <button id="mobile-menu-btn" class="lg:hidden text-white p-2 hover:bg-white/10 rounded-lg transition-all" aria-label="Toggle navigation">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- MENU PC -->
                <div class="hidden lg:flex items-center justify-center flex-1">
                    <ul class="flex items-center gap-4">
                        <li><a href="{{ route('home') }}" class="nav-link">Accueil</a></li>
                        <li><a href="{{ route('products.watches') }}" class="nav-link">Montres</a></li>
                        <li><a href="{{ route('products.glasses') }}" class="nav-link">Lunettes</a></li>
                        <li><a href="#contact" class="nav-link">Contact</a></li>
                    </ul>
                </div>

                <!-- ACTIONS DROITE PC -->
                <div class="hidden lg:flex items-center gap-4">
                    @auth
                    <!-- Panier PC -->
                    <a href="{{ route('cart.index') }}" class="nav-link flex items-center gap-1.5 relative">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Panier</span>
                        @php
                            $cartCount = \App\Models\Panier::where('user_id', Auth::id())->sum('quantite');
                        @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-medium">
                            {{ $cartCount }}
                        </span>
                        @endif
                    </a>

                    <!-- Dropdown Mon Compte -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="nav-link flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-44 bg-black/90 backdrop-blur-sm rounded-lg shadow-xl py-2 z-50 border border-white/20"
                             style="display: none;">
                            <a href="{{ route('profile.index') }}" @click="open = false" class="block px-4 py-2.5 text-sm text-white hover:text-gray-300 hover:bg-white/10 transition-colors">
                                Mon Profil
                            </a>
                            <a href="{{ route('profile.orders') }}" @click="open = false" class="block px-4 py-2.5 text-sm text-white hover:text-gray-300 hover:bg-white/10 transition-colors">
                                Mes Commandes
                            </a>
                            <div class="border-t border-white/20 my-2"></div>
                            <form action="{{ route('logout') }}" method="POST" @submit="open = false">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-400 hover:text-red-300 hover:bg-white/10 transition-colors">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>

                    @else
                    <!-- Panier PC (visiteur) -->
                    <a href="{{ route('cart.index') }}" class="nav-link flex items-center gap-1.5 relative">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Panier</span>
                        @php
                            $sessionCart = session('cart', []);
                            $sessionCount = collect($sessionCart)->sum('quantite');
                        @endphp
                        @if($sessionCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-medium">
                            {{ $sessionCount }}
                        </span>
                        @endif
                    </a>

                    <!-- Dropdown Mon Compte (visiteur) -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="nav-link flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Mon Compte</span>
                            <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-44 bg-black/90 backdrop-blur-sm rounded-lg shadow-xl py-2 z-50 border border-white/20"
                             style="display: none;">
                            <a href="{{ route('register') }}" @click="open = false" class="block px-4 py-2.5 text-sm text-white hover:text-gray-300 hover:bg-white/10 transition-colors">
                                S'inscrire
                            </a>
                            <a href="{{ route('login') }}" @click="open = false" class="block px-4 py-2.5 text-sm text-white hover:text-gray-300 hover:bg-white/10 transition-colors">
                                Se connecter
                            </a>
                        </div>
                    </div>
                    @endauth
                </div>

                <!-- MENU MOBILE -->
                <div id="mobile-menu" class="hidden lg:hidden absolute top-16 left-0 right-0 bg-black/70 backdrop-blur-sm border-b border-white/20 z-50">
                    <ul class="py-4 space-y-2 px-4">
                        <li><a href="{{ route('home') }}" class="block text-white hover:text-gray-300 py-3 px-4 font-medium rounded-lg hover:bg-white/5 transition-all text-base">Accueil</a></li>
                        <li><a href="{{ route('products.watches') }}" class="block text-white hover:text-gray-300 py-3 px-4 font-medium rounded-lg hover:bg-white/5 transition-all text-base">Montres</a></li>
                        <li><a href="{{ route('products.glasses') }}" class="block text-white hover:text-gray-300 py-3 px-4 font-medium rounded-lg hover:bg-white/5 transition-all text-base">Lunettes</a></li>
                        <li><a href="#contact" class="block text-white hover:text-gray-300 py-3 px-4 font-medium rounded-lg hover:bg-white/5 transition-all text-base">Contact</a></li>

                        @auth
                        <li><a href="{{ route('cart.index') }}" class="block text-white hover:text-gray-300 py-3 px-4 font-medium rounded-lg hover:bg-white/5 transition-all text-base">
                            Panier
                            @if($cartCount > 0)
                                <span class="ml-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $cartCount }}</span>
                            @endif
                        </a></li>

                        <li class="border-t border-white/20 pt-4 mt-4" x-data="{ open: false }">
                            <button @click="open = !open" class="w-full flex items-center justify-between text-white hover:text-gray-300 hover:bg-white/5 py-3 px-4 font-medium rounded-lg transition-all">
                                <span class="text-base">Mon Compte</span>
                                <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" class="mt-2 ml-4 space-y-2" style="display: none;">
                                <a href="{{ route('profile.index') }}" class="block text-gray-300 hover:text-white py-2 pl-4 border-l-2 border-white/30 hover:border-white transition-colors text-sm">
                                    Mon Profil
                                </a>
                                <a href="{{ route('profile.orders') }}" class="block text-gray-300 hover:text-white py-2 pl-4 border-l-2 border-white/30 hover:border-white transition-colors text-sm">
                                    Mes Commandes
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left text-red-400 hover:text-red-300 py-2 pl-4 border-l-2 border-white/30 hover:border-white transition-colors text-sm">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </li>

                        @else
                        <li><a href="{{ route('cart.index') }}" class="block text-white hover:text-gray-300 py-3 px-4 font-medium rounded-lg hover:bg-white/5 transition-all text-base">
                            Panier
                            @if($sessionCount > 0)
                                <span class="ml-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $sessionCount }}</span>
                            @endif
                        </a></li>

                        <li class="border-t border-white/20 pt-4 mt-4" x-data="{ open: false }">
                            <button @click="open = !open" class="w-full flex items-center justify-between text-white hover:text-gray-300 hover:bg-white/5 py-3 px-4 font-medium rounded-lg transition-all">
                                <span class="text-base">Mon Compte</span>
                                <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" class="mt-2 ml-4 space-y-2" style="display: none;">
                                <a href="{{ route('register') }}" class="block text-gray-300 hover:text-white py-2 pl-4 border-l-2 border-white/30 hover:border-white transition-colors text-sm">
                                    S'inscrire
                                </a>
                                <a href="{{ route('login') }}" class="block text-gray-300 hover:text-white py-2 pl-4 border-l-2 border-white/30 hover:border-white transition-colors text-sm">
                                    Se connecter
                                </a>
                            </div>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
/* Import des polices élégantes */
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Cormorant+Garamond:wght@400;500&display=swap');

/* Style translucide du header */
.navbar-dark {
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

/* Logo TIMEVA stylisé */
.logo-timeva {
    font-family: 'Cinzel', serif;
    font-size: 1.75rem;
    font-weight: 600;
    color: white;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    position: relative;
    transition: all 0.3s ease;
}

.logo-timeva::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 100%;
    height: 1px;
    background: linear-gradient(90deg, transparent, white, transparent);
    opacity: 0;
    transition: opacity 0.3s;
}

.logo-timeva:hover {
    color: #f3f4f6;
    letter-spacing: 0.25em;
}

.logo-timeva:hover::after {
    opacity: 1;
}

/* Navigation links avec police élégante */
.nav-link {
    font-family: 'Cormorant Garamond', serif;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    font-weight: 500;
    color: white;
    border-radius: 0.5rem;
    letter-spacing: 0.05em;
    position: relative;
    transition: all 0.3s ease;
}

.nav-link::before {
    content: '';
    position: absolute;
    bottom: 2px;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: 80%;
    height: 1px;
    background: white;
    transition: transform 0.3s ease;
}

.nav-link:hover {
    color: #f3f4f6;
    letter-spacing: 0.08em;
}

.nav-link:hover::before {
    transform: translateX(-50%) scaleX(1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    
    if (btn && menu) {
        btn.addEventListener('click', function() {
            menu.classList.toggle('hidden');
        });
    }
});
</script>