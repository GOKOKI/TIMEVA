@extends('layout.app')

@section('title', 'Finaliser la commande')

@section('content')
<div class="container mx-auto px-4 py-12">

    <h1 class="text-3xl font-bold text-gray-900 mb-8">Finaliser la commande</h1>

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm mb-6">
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ===== FORMULAIRE ADRESSE DE LIVRAISON ===== --}}
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
                @csrf

                <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">Adresse de livraison</h2>

                    @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        @foreach($errors->all() as $error)
                        <p class="text-sm text-red-600">{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif

                    <div class="space-y-4">
                        {{-- Adresse --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Adresse complète <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="adresse_livraison"
                                   value="{{ old('adresse_livraison', auth()->user()->profil?->adresse) }}"
                                   placeholder="Ex : 12 rue de la Paix, Quartier Haie Vive"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 @error('adresse_livraison') border-red-400 @enderror">
                            @error('adresse_livraison')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Code postal + Pays --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Code postal <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="code_postal"
                                       value="{{ old('code_postal', auth()->user()->profil?->code_postal) }}"
                                       placeholder="Ex : 01 BP 1234"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 @error('code_postal') border-red-400 @enderror">
                                @error('code_postal')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Pays <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="pays_expedition"
                                       value="{{ old('pays_expedition', auth()->user()->profil?->pays ?? 'Bénin') }}"
                                       placeholder="Ex : Bénin"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 @error('pays_expedition') border-red-400 @enderror">
                                @error('pays_expedition')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== MODE DE PAIEMENT ===== --}}
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">Mode de paiement</h2>

                    <div class="border-2 border-gray-900 rounded-xl p-4 flex items-center gap-4 bg-gray-50">
                        <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">FedaPay</p>
                            <p class="text-sm text-gray-500">Mobile Money, carte bancaire et plus</p>
                        </div>
                        <div class="ml-auto">
                            <div class="w-4 h-4 rounded-full bg-gray-900 border-2 border-gray-900 flex items-center justify-center">
                                <div class="w-2 h-2 rounded-full bg-white"></div>
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-gray-400 mt-3">
                        Vous serez redirigé vers la plateforme sécurisée FedaPay pour effectuer votre paiement.
                    </p>
                </div>

            </form>
        </div>

        {{-- ===== RÉCAPITULATIF COMMANDE ===== --}}
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-200 rounded-xl p-6 sticky top-24">
                <h2 class="text-lg font-bold text-gray-900 mb-5">Récapitulatif</h2>

                <div class="space-y-3 mb-5">
                    @foreach($cart as $variantId => $item)
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center p-1 shrink-0">
                            <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : asset('images/placeholder.jpg') }}"
                                 alt="{{ $item['name'] }}"
                                 class="w-full h-full object-contain">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</p>
                            @if(!empty($item['variant_name']))
                            <p class="text-xs text-gray-400">{{ $item['variant_name'] }}</p>
                            @endif
                            <p class="text-xs text-gray-500">Qté : {{ $item['quantity'] }}</p>
                        </div>
                        <p class="text-sm font-semibold text-gray-900 shrink-0">
                            {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }}
                        </p>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-100 pt-4 space-y-2 mb-5">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Sous-total</span>
                        <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Livraison</span>
                        <span class="text-green-600 font-medium">Gratuite</span>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4 flex justify-between items-center mb-6">
                    <span class="font-bold text-gray-900">Total</span>
                    <span class="text-xl font-bold text-gray-900">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                </div>

                {{-- Bouton payer --}}
                <button type="submit" form="checkout-form"
                        class="w-full bg-gray-900 text-white py-4 rounded-full text-base font-semibold
                               hover:bg-black transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Payer avec FedaPay
                </button>

                <a href="{{ route('cart.index') }}"
                   class="block text-center text-sm text-gray-400 hover:text-gray-700 mt-3">
                    ← Modifier le panier
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
