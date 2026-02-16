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

            <!-- Actions utilisateur -->
            <div class="flex items-center gap-4">
                @auth
                    {{-- UTILISATEUR CONNECTÉ --}}
                    
                    <!-- Panier avec badge dynamique -->
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

                    <!-- Menu utilisateur avec dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 p-2 border-2 border-black rounded-lg hover:bg-gray-100 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 ml-1 transition-transform" 
                                 :class="{ 'rotate-180': open }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                            
                            {{-- Ces liens ferment le menu au clic --}}
                            <a href="{{ route('profile.index') }}" 
                               @click="open = false"
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Mon profil</span>
                                </div>
                            </a>
                            
                            <a href="{{ route('profile.orders') }}" 
                               @click="open = false"
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <span>Mes commandes</span>
                                </div>
                            </a>
                            
                            <div class="border-t border-gray-200 my-2"></div>
                            
                            {{-- Le formulaire aussi ferme le menu --}}
                            <form action="{{ route('logout') }}" method="POST" @submit="open = false">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span>Déconnexion</span>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>

                @else
                    {{-- VISITEUR NON CONNECTÉ --}}
                    
                    <!-- Panier (session) -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @php
                            $sessionCart = session('cart', []);
                            $sessionCount = collect($sessionCart)->sum('quantite');
                        @endphp
                        @if($sessionCount > 0)
                        <span class="absolute -top-1 -right-1 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-medium">
                            {{ $sessionCount }}
                        </span>
                        @endif
                    </a>

                    <!-- Connexion / Inscription -->
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-black font-medium transition-colors px-3 py-2">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                        Inscription
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>