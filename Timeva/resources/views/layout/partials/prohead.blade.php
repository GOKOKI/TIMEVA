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
                <!-- Panier avec badge -->
                <a href="{{ route('cart') }}" class="relative p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-medium">
                        3
                    </span>
                </a>

                <!-- Icône utilisateur -->
                <a href="{{ route('account') }}" class="p-2 border-2 border-black rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>

                <!-- Bouton déconnexion -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-700 hover:text-black font-medium transition-colors">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>