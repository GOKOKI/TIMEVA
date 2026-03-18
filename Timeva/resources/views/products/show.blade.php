@extends('layout.app')

@section('title', $product->name)

@section('content')

@php
    $variants    = $product->variants;
    $colors      = $variants->pluck('color')->filter()->unique()->values();
    $sizes       = $variants->pluck('size')->filter()->unique()->values();
    $variantsJson = $variants->map(fn($v) => [
        'id'    => $v->id,
        'color' => $v->color,
        'size'  => $v->size,
        'stock' => $v->stock_quantity,
    ])->toJson();
@endphp

<div class="max-w-6xl mx-auto px-4 py-12">

    {{-- Fil d'Ariane --}}
    <nav class="text-sm text-gray-400 mb-10 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-gray-700 transition-colors">Accueil</a>
        <span>/</span>
        <a href="{{ route('products.' . $product->category) }}" class="hover:text-gray-700 transition-colors">
            {{ $product->category === 'watches' ? 'Montres' : 'Lunettes' }}
        </a>
        <span>/</span>
        <span class="text-gray-700 font-medium">{{ $product->name }}</span>
    </nav>

    <div x-data="{
        allVariants: {{ $variantsJson }},
        selectedColor: null,
        selectedSize: null,

        get matchedVariant() {
            if (!this.selectedColor) return null;
            return this.allVariants.find(v =>
                v.color === this.selectedColor &&
                (v.size === this.selectedSize || (!v.size && !this.selectedSize))
            ) ?? null;
        },
        get stock() { return this.matchedVariant ? this.matchedVariant.stock : 0; },
        get canAddToCart() { return this.matchedVariant && this.matchedVariant.stock > 0; },

        pick(color, size) {
            this.selectedColor = color;
            if (size !== undefined) this.selectedSize = size;
            this.$nextTick(() => this.syncForm());
        },
        syncForm() {
            const v = this.matchedVariant;
            const form = document.getElementById('add-to-cart-form');
            const btn  = document.getElementById('addToCartBtn');
            const qty  = document.getElementById('quantity_input');
            if (v) {
                form.action = '{{ url('cart/add') }}/' + v.id;
                btn.disabled = v.stock <= 0;
                qty.max = v.stock;
            } else {
                form.action = '#';
                btn.disabled = true;
            }
        }
    }" class="grid grid-cols-1 lg:grid-cols-2 gap-16">

        {{-- ===== IMAGE ===== --}}
        <div class="aspect-square rounded-2xl overflow-hidden">
            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover">
        </div>

        {{-- ===== INFOS ===== --}}
        <div class="flex flex-col justify-center">

            {{-- Marque --}}
            <span class="text-xs font-semibold tracking-widest uppercase text-teal-600 mb-4">
                {{ $product->brand ?? 'TIMEVA' }}
            </span>

            {{-- Nom --}}
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-5 leading-tight">
                {{ $product->name }}
            </h1>

            {{-- Prix --}}
            <p class="text-2xl font-bold text-gray-900 mb-6">
                {{ number_format($product->prix, 0, ',', ' ') }} FCFA
            </p>

            {{-- Description --}}
            @if($product->description)
            <p class="text-gray-500 leading-relaxed mb-8 text-sm">{{ $product->description }}</p>
            @endif

            {{-- ===== COULEURS ===== --}}
            @if($colors->count())
            <div class="mb-7">
                <p class="text-sm font-bold text-gray-900 mb-3">Couleur</p>
                <div class="flex flex-wrap gap-3">
                    @foreach($colors as $color)
                    <button type="button"
                            @click="pick('{{ $color }}')"
                            :class="selectedColor === '{{ $color }}'
                                ? 'ring-2 ring-offset-2 ring-yellow-400 scale-110'
                                : 'ring-1 ring-gray-200 hover:ring-gray-400'"
                            class="w-9 h-9 rounded-full transition-all duration-200 shadow-sm"
                            style="background-color: {{ $color }};"
                            title="{{ $color }}">
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ===== TAILLES ===== --}}
            @if($sizes->count())
            <div class="mb-7">
                <p class="text-sm font-bold text-gray-900 mb-3">Taille</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($sizes as $size)
                    <button type="button"
                            @click="pick(selectedColor, '{{ $size }}')"
                            :class="selectedSize === '{{ $size }}'
                                ? 'bg-gray-900 text-white border-gray-900'
                                : 'bg-white text-gray-700 border-gray-300 hover:border-gray-700'"
                            class="px-5 py-2 rounded-lg border text-sm font-medium transition-all duration-200">
                        {{ $size }}
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Disponibilité --}}
            <div class="mb-6 h-5">
                <span x-show="matchedVariant && stock > 0"
                      class="text-sm text-green-600 font-medium"
                      style="display:none">
                    ✓ <span x-text="stock"></span> en stock
                </span>
                <span x-show="matchedVariant && stock <= 0"
                      class="text-sm text-red-500 font-medium"
                      style="display:none">
                    Rupture de stock
                </span>
                <span x-show="!selectedColor && {{ $variants->count() }} > 0"
                      class="text-sm text-gray-400"
                      style="display:none">
                    Sélectionnez une couleur pour continuer
                </span>
            </div>

            {{-- ===== QUANTITÉ + PANIER ===== --}}
            <form id="add-to-cart-form" action="#" method="POST">
                @csrf
                <div class="flex items-center gap-4">

                    {{-- Quantité --}}
                    <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                        <button type="button"
                                onclick="const q=document.getElementById('quantity_input'); if(q.value>1) q.value--;"
                                class="px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors text-lg font-medium">−</button>
                        <input type="number" name="quantity" id="quantity_input" value="1" min="1"
                               class="w-14 text-center border-0 focus:outline-none text-sm font-semibold py-3">
                        <button type="button"
                                onclick="const q=document.getElementById('quantity_input'); const mx=parseInt(q.max||999); if(!q.max||parseInt(q.value)<mx) q.value++;"
                                class="px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors text-lg font-medium">+</button>
                    </div>

                    {{-- Ajouter au panier --}}
                    @auth
                    <button type="submit"
                            id="addToCartBtn"
                            {{ $variants->count() ? 'disabled' : '' }}
                            class="flex-1 bg-gray-900 text-white py-3.5 rounded-xl text-sm font-semibold
                                   hover:bg-black transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                        Ajouter au panier
                    </button>
                    @else
                    <a href="{{ route('login') }}"
                       class="flex-1 text-center bg-gray-900 text-white py-3.5 rounded-xl text-sm font-semibold hover:bg-black transition-colors">
                        Se connecter pour acheter
                    </a>
                    @endauth
                </div>
            </form>

        </div>
    </div>

    {{-- ===== PRODUITS SIMILAIRES ===== --}}
    @if(isset($similaires) && $similaires->count())
    <div class="mt-20 border-t border-gray-100 pt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Vous aimerez aussi</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($similaires as $item)
            @php $itemStock = $item->variants->sum('stock_quantity'); @endphp
            <a href="{{ route('products.show', $item->slug) }}" class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="relative aspect-square bg-gray-100">
                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/placeholder.jpg') }}"
                         alt="{{ $item->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @if($itemStock > 0 && $itemStock <= 3)
                    <span class="absolute top-2 right-2 bg-white text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded-full shadow-sm">
                        Plus que {{ $itemStock }}
                    </span>
                    @endif
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">{{ $item->brand }}</p>
                    <h4 class="text-sm font-bold text-gray-900 mb-2">{{ $item->name }}</h4>
                    <p class="text-sm font-bold text-gray-900">{{ number_format($item->prix, 0, ',', ' ') }} FCFA</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
