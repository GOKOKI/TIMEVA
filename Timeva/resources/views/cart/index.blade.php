@extends('layout.app')

@section('title', 'Mon panier')

@section('content')
<div class="container mx-auto px-4 py-12">

    <h1 class="text-3xl font-bold text-gray-900 mb-8">Mon panier</h1>

    {{-- Messages flash --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm mb-6">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm mb-6">
        {{ session('error') }}
    </div>
    @endif

    @if(!empty($cart))

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ===== LISTE DES ARTICLES ===== --}}
        <div class="lg:col-span-2 space-y-4">

            @foreach($cart as $variantId => $item)
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <div class="flex gap-5">

                    {{-- Image --}}
                    <div class="w-24 h-24 bg-gray-50 rounded-lg flex-shrink-0 flex items-center justify-center p-2">
                        <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : asset('images/placeholder.jpg') }}"
                             alt="{{ $item['name'] }}"
                             class="w-full h-full object-contain">
                    </div>

                    {{-- Infos --}}
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $item['name'] }}</h3>
                                @if(!empty($item['variant_name']))
                                <p class="text-sm text-gray-500 mt-0.5">{{ $item['variant_name'] }}</p>
                                @endif
                            </div>

                            {{-- Supprimer --}}
                            <form action="{{ route('cart.remove', $variantId) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        {{-- Prix + Quantité --}}
                        <div class="flex items-center justify-between mt-4">
                            <p class="text-lg font-bold text-gray-900">
                                {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA
                            </p>

                            {{-- Contrôles quantité --}}
                            <div class="flex items-center border border-gray-200 rounded-full overflow-hidden">
                                {{-- Diminuer --}}
                                <form action="{{ route('cart.update', $variantId) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                    <button type="submit"
                                            class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors text-lg font-medium leading-none
                                                   {{ $item['quantity'] <= 1 ? 'opacity-30 cursor-not-allowed' : '' }}"
                                            {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                        −
                                    </button>
                                </form>

                                <span class="px-3 text-sm font-semibold text-gray-900 min-w-[2rem] text-center">
                                    {{ $item['quantity'] }}
                                </span>

                                {{-- Augmenter --}}
                                <form action="{{ route('cart.update', $variantId) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                    <button type="submit"
                                            class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors text-lg font-medium leading-none">
                                        +
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p class="text-xs text-gray-400 mt-1">
                            {{ number_format($item['price'], 0, ',', ' ') }} FCFA / unité
                        </p>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Vider le panier --}}
            <div class="flex justify-end">
                <form action="{{ route('cart.clear') }}" method="POST"
                      onsubmit="return confirm('Vider tout le panier ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium">
                        Vider le panier
                    </button>
                </form>
            </div>

        </div>

        {{-- ===== RÉCAPITULATIF ===== --}}
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-200 rounded-xl p-6 sticky top-24">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Récapitulatif</h2>

                {{-- Détail articles --}}
                <div class="space-y-2 mb-4">
                    @foreach($cart as $item)
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                        <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-100 pt-4 mb-4">
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
                        <span>Livraison</span>
                        <span class="text-green-600 font-medium">Gratuite</span>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6 border-t border-gray-200 pt-4">
                    <span class="text-lg font-bold text-gray-900">Total</span>
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                </div>

                <a href="{{ route('checkout.index') }}"
                   class="block w-full bg-gray-900 text-white text-center py-4 rounded-full text-base font-semibold
                          hover:bg-black transition-colors mb-3">
                    Passer la commande →
                </a>

                <a href="{{ route('home') }}"
                   class="block text-center text-sm text-gray-500 hover:text-gray-900 transition-colors">
                    Continuer mes achats
                </a>
            </div>
        </div>

    </div>

    @else

    {{-- Panier vide --}}
    <div class="text-center py-20">
        <svg class="w-24 h-24 mx-auto text-gray-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Votre panier est vide</h2>
        <p class="text-gray-500 mb-8">Découvrez nos collections de montres et lunettes.</p>
        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('products.watches') }}"
               class="bg-gray-900 text-white px-8 py-3 rounded-full font-medium hover:bg-black transition-colors">
                Voir les montres
            </a>
            <a href="{{ route('products.glasses') }}"
               class="border border-gray-300 text-gray-700 px-8 py-3 rounded-full font-medium hover:border-gray-900 hover:text-gray-900 transition-colors">
                Voir les lunettes
            </a>
        </div>
    </div>

    @endif

</div>
@endsection
