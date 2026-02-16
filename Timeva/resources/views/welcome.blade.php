@extends('layout.app') 
@section('title', 'Accueil - TIMEVA')

@section('content')
<div class="bg-gray-50">
    
    <!-- Hero Section -->
    <section class="relative py-20 px-6 bg-gradient-to-br from-white via-gray-50 to-gray-100">
        <div class="max-w-5xl mx-auto text-center">
            <span class="badge-collection">
                Nouvelle Collection 2026
            </span>
            <h1 class="hero-title">
                L'Élégance à Portée de Main
            </h1>
            <p class="hero-description">
                Découvrez notre sélection exclusive de montres et lunettes de luxe. Qualité exceptionnelle, design intemporel.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('products.watches') }}" class="btn-primary">
                    Explorer les Montres →
                </a>
                <a href="{{ route('products.glasses') }}" class="btn-secondary">
                    Explorer les Lunettes
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 text-gray-900 rounded-2xl mb-5 group-hover:bg-gray-900 group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="8" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3 class="section-title">Montres de Prestige</h3>
                    <p class="text-gray-600">Des pièces d'horlogerie d'exception pour sublimer chaque instant.</p>
                </div>
                
                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 text-gray-900 rounded-2xl mb-5 group-hover:bg-gray-900 group-hover:text-white transition-all">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <!-- Lunettes -->
                            <ellipse cx="7" cy="12" rx="3" ry="2.5"/>
                            <ellipse cx="17" cy="12" rx="3" ry="2.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 12h4M4 12l-2-2M20 12l2-2"/>
                        </svg>
                    </div>
                    <h3 class="section-title">Lunettes Exclusives</h3>
                    <p class="text-gray-600">Affirmez votre personnalité avec nos montures uniques.</p>
                </div>
                
                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 text-gray-900 rounded-2xl mb-5 group-hover:bg-gray-900 group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="section-title">Design Intemporel</h3>
                    <p class="text-gray-600">Des créations élégantes qui traversent les époques.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Produits Vedettes -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-14">
                <h2 class="page-title">Produits Vedettes</h2>
                <p class="page-subtitle">Découvrez notre sélection exclusive</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($produitsVedettes ?? [] as $produit)
                <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                    <a href="{{ route('products.show', $produit->id) }}" class="block">
                        <div class="aspect-square bg-gray-100 flex items-center justify-center p-6 overflow-hidden">
                            <img src="{{ $produit->img ?? asset('images/placeholder.jpg') }}" 
                                 alt="{{ $produit->nom }}" 
                                 class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-5">
                            <p class="product-brand">{{ $produit->marque ?? 'TIMEVA' }}</p>
                            <h4 class="product-name">{{ $produit->nom }}</h4>
                            <p class="product-price">{{ number_format($produit->prix, 2) }} €</p>
                            
                            @if(isset($produit->variantes) && $produit->variantes->isNotEmpty())
                                <div class="flex gap-2">
                                    @foreach($produit->variantes->pluck('couleur')->filter()->unique()->take(4) as $couleur)
                                        <span class="w-6 h-6 rounded-full border-2 border-gray-300 hover:border-gray-900 transition-colors cursor-pointer" 
                                              style="background-color: {{ $couleur }};"
                                              title="{{ $couleur }}"></span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </a>
                </div>
                @empty
                <!-- Produits de démonstration -->
                @for($i = 1; $i <= 4; $i++)
                <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                    <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center p-6">
                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="p-5">
                        <p class="product-brand">TIMEVA</p>
                        <h4 class="product-name">
                            {{ $i <= 2 ? 'Montre Premium ' . $i : 'Lunettes Style ' . ($i - 2) }}
                        </h4>
                        <p class="product-price">{{ number_format(rand(150, 4000), 2) }} €</p>
                        <div class="flex gap-2">
                            <span class="w-6 h-6 rounded-full bg-gray-900 border-2 border-gray-300"></span>
                            <span class="w-6 h-6 rounded-full bg-gray-500 border-2 border-gray-300"></span>
                        </div>
                    </div>
                </div>
                @endfor
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('products.watches') }}" class="btn-primary-large">
                    Voir toute la collection →
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-900 text-white rounded-2xl mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Authenticité Garantie</h3>
                    <p class="text-gray-600">Tous nos produits sont 100% authentiques et certifiés.</p>
                </div>
                
                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-900 text-white rounded-2xl mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Livraison Express</h3>
                    <p class="text-gray-600">Livraison gratuite sous 24-48h partout en France.</p>
                </div>
                
                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-900 text-white rounded-2xl mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14v-6a4 4 0 00-4-4h-1.5"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Retours Faciles</h3>
                    <p class="text-gray-600">30 jours pour changer d'avis, retour gratuit et sans frais.</p>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Import des polices élégantes */
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Cormorant+Garamond:wght@400;500;600&family=Playfair+Display:wght@400;600;700&display=swap');

/* Badge Collection */
.badge-collection {
    display: inline-block;
    padding: 0.25rem 1rem;
    background: #111827;
    color: white;
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    border-radius: 9999px;
    margin-bottom: 1.5rem;
}

/* Hero Title */
.hero-title {
    font-family: 'Cinzel', serif;
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 700;
    color: #111827;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    letter-spacing: 0.02em;
}

/* Hero Description */
.hero-description {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.125rem, 2vw, 1.25rem);
    color: #4b5563;
    max-width: 42rem;
    margin: 0 auto 2.5rem;
    line-height: 1.6;
}

/* Buttons */
.btn-primary {
    padding: 1rem 2rem;
    background: #111827;
    color: white;
    border-radius: 0.5rem;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1rem;
    font-weight: 500;
    letter-spacing: 0.05em;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

.btn-primary:hover {
    background: #1f2937;
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.15);
    transform: scale(1.05);
}

.btn-secondary {
    padding: 1rem 2rem;
    background: white;
    color: #111827;
    border: 2px solid #111827;
    border-radius: 0.5rem;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1rem;
    font-weight: 500;
    letter-spacing: 0.05em;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

.btn-secondary:hover {
    background: #111827;
    color: white;
}

.btn-primary-large {
    display: inline-block;
    padding: 1rem 2.5rem;
    background: #111827;
    color: white;
    border-radius: 0.5rem;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1rem;
    font-weight: 500;
    letter-spacing: 0.05em;
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

.btn-primary-large:hover {
    background: #1f2937;
    box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
}

/* Page Titles */
.page-title {
    font-family: 'Cinzel', serif;
    font-size: clamp(2rem, 4vw, 2.5rem);
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.75rem;
    letter-spacing: 0.02em;
}

.page-subtitle {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.125rem;
    color: #4b5563;
    font-weight: 500;
}

/* Section Titles */
.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.25rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.75rem;
    letter-spacing: 0.01em;
}

.service-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.25rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.75rem;
}

/* Product Cards */
.product-brand {
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.75rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.product-name {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.75rem;
    min-height: 3rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-price {
    font-family: 'Cinzel', serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 1rem;
}
</style>
@endsection