@extends('layout.app') 
@section('title', 'Accueil')

@section('content')
<div class="bg-gray-50">
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-16 text-center">
        <p class="text-sm text-gray-500 uppercase mb-2">Nouvelle collection 2026</p>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">L'Élégance à Portée de Main</h1>
        <p class="text-gray-600 text-lg mb-8">Découvrez notre sélection exclusive de montres et lunettes de luxe. Qualité exceptionnelle, design intemporel.</p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('products.watches') }}" class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">Explorer les Montres</a>
            <a href="{{ route('products.glasses') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-100 transition">Explorer les Lunettes</a>
        </div>
    </section>

    <!-- Features Section avec SVG -->
    <section class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition group">
            <div class="text-4xl mb-4 flex justify-center">
                <svg class="w-12 h-12 text-gray-900 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="8" stroke-width="2"/>
                    <path d="M12 6v6l4 2" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <h3 class="font-semibold text-lg mb-2">Montres</h3>
            <p class="text-gray-500 text-sm">Des montres de prestige pour chaque moment de votre vie.</p>
        </div>
        <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition group">
            <div class="text-4xl mb-4 flex justify-center">
                <svg class="w-12 h-12 text-gray-900 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M2 12h4m12 0h4M6 12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2M6 12c0-1.1.9-2 2-2h8c1.1 0 2 .9 2 2" stroke-width="2"/>
                </svg>
            </div>
            <h3 class="font-semibold text-lg mb-2">Lunettes</h3>
            <p class="text-gray-500 text-sm">Affirmez votre style avec nos montures exclusives.</p>
        </div>
        <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition group">
            <div class="text-4xl mb-4 flex justify-center">
                <svg class="w-12 h-12 text-gray-900 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
            </div>
            <h3 class="font-semibold text-lg mb-2">Styles</h3>
            <p class="text-gray-500 text-sm">Accompagnez votre style avec nos ensembles.</p>
        </div>
    </section>

    <!-- Produits Vedettes -->
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Produits Vedettes</h2>
                <p class="text-gray-500">Notre sélection du moment</p>
            </div>
            <a href="{{ route('products.watches') }}" class="text-gray-900 font-semibold hover:underline">Voir tout</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($produitsVedettes ?? [] as $produit)
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow group">
                <a href="{{ route('products.show', $produit) }}" class="block">
                    <div class="aspect-square bg-gray-100 flex items-center justify-center p-8 group-hover:bg-gray-200 transition-colors">
                        <img src="{{ $produit->img ?? asset('images/placeholder.jpg') }}" 
                             alt="{{ $produit->nom }}" 
                             class="w-full h-full object-contain transition-transform group-hover:scale-110 duration-300">
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ $produit->marque ?? 'TIMEVA' }}</p>
                        <h4 class="text-lg font-semibold mb-2 group-hover:text-gray-900">{{ $produit->nom }}</h4>
                        <p class="text-xl font-bold mb-3">{{ number_format($produit->prix, 2) }} €</p>
                        
                        @if($produit->variantes->isNotEmpty())
                            <div class="flex gap-2">
                                @foreach($produit->variantes->pluck('couleur')->filter()->unique()->take(3) as $couleur)
                                    <span class="w-5 h-5 rounded-full border-2 border-gray-300 cursor-pointer" 
                                          style="background-color: {{ $couleur }};"
                                          title="{{ $couleur }}"></span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            </div>
            @empty
            {{-- Produits de démonstration si pas de BDD --}}
            <!-- Produit 1 - Montre -->
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow group">
                <a href="{{ route('products.show', 1) }}" class="block">
                    <div class="aspect-square bg-gray-100 flex items-center justify-center p-8">
                        <img src="{{ asset('images/watches1.jpg') }}" alt="Chronographe Royal" class="w-full h-full object-contain">
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">TIMEVA</p>
                        <h4 class="text-lg font-semibold mb-2">Chronographe Royal</h4>
                        <p class="text-xl font-bold mb-3">2350.00 €</p>
                        <div class="flex gap-2">
                            <span class="w-5 h-5 rounded-full bg-gray-300 border-2 border-gray-400"></span>
                            <span class="w-5 h-5 rounded-full bg-black border-2 border-gray-300"></span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Produit 2 - Montre -->
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow group">
                <a href="{{ route('products.show', 2) }}" class="block">
                    <div class="aspect-square bg-gray-100 flex items-center justify-center p-8">
                        <img src="{{ asset('images/watches2.jpg') }}" alt="Classique Or Rose" class="w-full h-full object-contain">
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">TIMEVA</p>
                        <h4 class="text-lg font-semibold mb-2">Classique Or Rose</h4>
                        <p class="text-xl font-bold mb-3">3740.00 €</p>
                        <div class="flex gap-2">
                            <span class="w-5 h-5 rounded-full bg-rose-400 border-2 border-gray-300"></span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Produit 3 - Lunettes -->
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow group">
                <a href="{{ route('products.show', 3) }}" class="block">
                    <div class="aspect-square bg-gray-100 flex items-center justify-center p-8">
                        <img src="{{ asset('images/glasses1.jpg') }}" alt="Cat Eye Élégance" class="w-full h-full object-contain">
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">TIMEVA GLASSES</p>
                        <h4 class="text-lg font-semibold mb-2">Cat Eye Élégance</h4>
                        <p class="text-xl font-bold mb-3">280.00 €</p>
                        <div class="flex gap-2">
                            <span class="w-5 h-5 rounded-full bg-black border-2 border-gray-300"></span>
                            <span class="w-5 h-5 rounded-full bg-amber-700 border-2 border-gray-300"></span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Produit 4 - Lunettes -->
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow group">
                <a href="{{ route('products.show', 4) }}" class="block">
                    <div class="aspect-square bg-gray-100 flex items-center justify-center p-8">
                        <img src="{{ asset('images/glasses2.jpg') }}" alt="Aviateur Classique" class="w-full h-full object-contain">
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">TIMEVA GLASSES</p>
                        <h4 class="text-lg font-semibold mb-2">Aviateur Classique</h4>
                        <p class="text-xl font-bold mb-3">150.00 €</p>
                        <div class="flex gap-2">
                            <span class="w-5 h-5 rounded-full bg-gray-800 border-2 border-gray-300"></span>
                            <span class="w-5 h-5 rounded-full bg-yellow-600 border-2 border-gray-300"></span>
                        </div>
                    </div>
                </a>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Services Section avec SVG -->
    <section class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition group">
            <div class="text-4xl mb-4 flex justify-center">
                <svg class="w-12 h-12 text-gray-900 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-lg mb-2">Authenticité Garantie</h3>
            <p class="text-gray-500 text-sm">Tous nos produits sont 100% authentiques.</p>
        </div>
        <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition group">
            <div class="text-4xl mb-4 flex justify-center">
                <svg class="w-12 h-12 text-gray-900 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                </svg>
            </div>
            <h3 class="font-semibold text-lg mb-2">Livraison Express</h3>
            <p class="text-gray-500 text-sm">Livraison gratuite en 24-48h pour toutes vos commandes.</p>
        </div>
        <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition group">
            <div class="text-4xl mb-4 flex justify-center">
                <svg class="w-12 h-12 text-gray-900 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14v-6a4 4 0 00-4-4h-1.5"/>
                </svg>
            </div>
            <h3 class="font-semibold text-lg mb-2">Retours Faciles</h3>
            <p class="text-gray-500 text-sm">30 jours pour changer d'avis, retour gratuit.</p>
        </div>
    </section>
</div>
@endsection