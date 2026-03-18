@extends('layout.app')

@section('title', $product->name)

@section('content')
<div class="container mx-auto px-4 py-12">

    {{-- Fil d'Ariane --}}
    <nav class="text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-gray-900">Accueil</a>
        <span class="mx-2">/</span>
        <a href="{{ route('products.' . $product->category) }}" class="hover:text-gray-900">
            {{ $product->category === 'watches' ? 'Montres' : 'Lunettes' }}
        </a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

        {{-- ===== IMAGE ===== --}}
        <div class="aspect-square bg-gray-50 rounded-2xl overflow-hidden flex items-center justify-center p-8">
            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-contain">
        </div>

        {{-- ===== INFOS PRODUIT ===== --}}
        <div class="flex flex-col justify-center" x-data="{ selectedVariant: null, selectedColor: null, stock: 0 }">

            {{-- Badge catégorie --}}
            <span class="inline-block text-xs font-medium tracking-widest uppercase text-gray-500 mb-3">
                {{ $product->brand }} · {{ $product->category === 'watches' ? 'Montre' : 'Lunettes' }}
            </span>

            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

            <p class="text-2xl font-bold text-gray-900 mb-6">
                {{ number_format($product->prix, 0, ',', ' ') }} FCFA
            </p>

            @if($product->description)
            <p class="text-gray-600 leading-relaxed mb-8">{{ $product->description }}</p>
            @endif

            {{-- ===== VARIANTES ===== --}}
            @if($product->variants && $product->variants->count())
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-semibold text-gray-900">Couleur</p>
                    <span x-text="selectedColor" class="text-sm text-gray-500"></span>
                </div>

                <div class="flex flex-wrap gap-2">
                    @foreach($product->variants as $variant)
                    <button type="button"
                            @click="selectedVariant = {{ $variant->id }}; selectedColor = '{{ $variant->color }}'; stock = {{ $variant->stock_quantity }};
                                    document.getElementById('add-to-cart-form').action = '{{ url('cart/add') }}/' + {{ $variant->id }};
                                    document.getElementById('addToCartBtn').disabled = {{ $variant->stock_quantity }} <= 0;
                                    document.getElementById('quantity_input').max = {{ $variant->stock_quantity }};"
                            :class="selectedVariant === {{ $variant->id }}
                                ? 'bg-gray-900 text-white border-gray-900'
                                : 'bg-white text-gray-700 border-gray-300 hover:border-gray-900'"
                            class="px-4 py-2 rounded-full border text-sm font-medium transition-all">
                        {{ $variant->color }}
                        @if($variant->size) · {{ $variant->size }} @endif
                    </button>
                    @endforeach
                </div>

                {{-- Disponibilité --}}
                <div class="mt-3 text-sm" x-show="selectedVariant !== null">
                    <span x-show="stock > 0" class="text-green-600 font-medium" style="display:none">
                        ✓ <span x-text="stock"></span> en stock
                    </span>
                    <span x-show="stock <= 0" class="text-red-500 font-medium" style="display:none">
                        Rupture de stock
                    </span>
                </div>
                <p class="mt-2 text-xs text-gray-400" x-show="selectedVariant === null">
                    Sélectionnez une couleur pour continuer
                </p>
            </div>
            @endif

            {{-- ===== QUANTITÉ + PANIER ===== --}}
            <form id="add-to-cart-form" action="#" method="POST"
                  data-base-url="{{ url('cart/add') }}">
                @csrf

                <div class="flex items-center gap-4 mb-4">
                    <div class="flex items-center border border-gray-300 rounded-full overflow-hidden">
                        <button type="button"
                                onclick="const q = document.getElementById('quantity_input'); if(q.value > 1) q.value--;"
                                class="px-4 py-2.5 text-gray-600 hover:bg-gray-100 transition-colors font-medium">−</button>
                        <input type="number" name="quantity" id="quantity_input" value="1" min="1"
                               class="w-14 text-center border-0 focus:outline-none text-sm font-medium">
                        <button type="button"
                                onclick="const q = document.getElementById('quantity_input'); const mx = parseInt(q.max||999); if(!q.max || parseInt(q.value) < mx) q.value++;"
                                class="px-4 py-2.5 text-gray-600 hover:bg-gray-100 transition-colors font-medium">+</button>
                    </div>
                </div>

                <button type="submit"
                        id="addToCartBtn"
                        {{ $product->variants->count() ? 'disabled' : '' }}
                        class="w-full bg-gray-900 text-white py-4 rounded-full text-base font-semibold
                               hover:bg-black transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                    @auth
                        Ajouter au panier
                    @else
                        <a href="{{ route('login') }}">Se connecter pour acheter</a>
                    @endauth
                </button>

                @guest
                <p class="text-center text-xs text-gray-400 mt-2">
                    <a href="{{ route('login') }}" class="underline hover:text-gray-700">Connexion</a> requise pour passer commande
                </p>
                @endguest
            </form>

        </div>
    </div>

    {{-- ===== PRODUITS SIMILAIRES ===== --}}
    @if(isset($similaires) && $similaires->count())
    <div class="mt-20">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Vous aimerez aussi</h2>
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($similaires as $item)
            <a href="{{ route('products.show', $item->slug) }}"
               class="group bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg transition-all">
                <div class="aspect-square bg-gray-50 flex items-center justify-center p-6 group-hover:bg-gray-100 transition-colors">
                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/placeholder.jpg') }}"
                         alt="{{ $item->name }}"
                         class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">{{ $item->brand }}</p>
                    <h4 class="text-sm font-semibold text-gray-900 mb-2 group-hover:text-black">{{ $item->name }}</h4>
                    <p class="text-base font-bold text-gray-900">{{ number_format($item->prix, 0, ',', ' ') }} FCFA</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
