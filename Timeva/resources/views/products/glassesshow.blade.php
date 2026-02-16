@extends('layout.app')
@section('title', $produit->nom ?? 'Détail produit')
@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Bouton Retour - CORRECTION ICI -->
    <a href="{{ url()->previous() ?? route('products.glasses') }}" class="inline-flex items-center gap-2 text-gray-700 hover:text-black mb-8">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        <span class="font-medium">Retour</span>
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Image du produit -->
        <div class="bg-gray-200 rounded-2xl overflow-hidden aspect-square flex items-center justify-center p-12">
            <img src="{{ $produit->img ?? asset('images/glasses1.jpg') }}" 
                 alt="{{ $produit->nom ?? 'Glasses' }}" 
                 class="w-full h-full object-contain">
        </div>

        <!-- Détails du produit -->
        <div class="flex flex-col">
            <p class="text-xs text-gray-500 uppercase tracking-widest mb-3">{{ $produit->marque ?? 'TIMEVA' }}</p>
            <h1 class="text-4xl lg:text-5xl font-bold mb-6">{{ $produit->nom ?? 'Carree Minialiste' }}</h1>
            <p class="text-3xl font-bold mb-6">{{ number_format($produit->prix ?? 120, 2) }} €</p>
            
            <p class="text-gray-600 mb-8 leading-relaxed">
                {{ $produit->description ?? 'Lunettes aviateur intemporelles avec monture en titane et verres polarisés anti-reflets' }}
            </p>

            @if($produit->variantes->isNotEmpty())
                @php $premiereVariante = $produit->variantes->first(); @endphp

                <!-- Couleur -->
                @if($produit->variantes->pluck('couleur')->filter()->isNotEmpty())
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Couleur</h3>
                    <div class="flex gap-3">
                        @foreach($produit->variantes->pluck('couleur')->filter()->unique() as $couleur)
                            <button class="w-12 h-12 rounded-full border-2 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2"
                                    style="background-color: {{ $couleur }}; border-color: {{ $couleur == '#000000' ? 'black' : 'gray' }}"
                                    onclick="selectCouleur('{{ $couleur }}')">
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Taille -->
                @if($produit->variantes->pluck('taille')->filter()->isNotEmpty())
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Taille</h3>
                    <div class="flex gap-3">
                        @foreach($produit->variantes->pluck('taille')->filter()->unique() as $taille)
                            <button class="px-6 py-3 border-2 border-gray-300 rounded-lg hover:border-gray-400 transition-colors font-medium"
                                    onclick="selectTaille('{{ $taille }}')">
                                {{ $taille }}
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Stock -->
                <p class="text-sm text-gray-700 mb-6" id="stock-display">
                    {{ $premiereVariante->quantite_stock ?? 0 }} en stock
                </p>

                <!-- Quantité -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Quantité</h3>
                    <div class="flex items-center gap-4">
                        <form action="{{ route('cart.update', $premiereVariante->id_variant) }}" method="POST" id="quantite-form" class="flex items-center gap-4">
                            @csrf
                            @method('PATCH')
                            <button type="button" 
                                    onclick="updateQuantite(-1)"
                                    class="w-12 h-12 border-2 border-gray-300 rounded-lg hover:border-gray-400 transition-colors flex items-center justify-center font-medium text-xl">
                                −
                            </button>
                            <input type="number" 
                                   name="quantite" 
                                   id="quantite" 
                                   value="1" 
                                   min="1" 
                                   max="{{ $premiereVariante->quantite_stock ?? 1 }}"
                                   class="text-xl font-medium w-16 text-center border-0 focus:ring-0">
                            <button type="button"
                                    onclick="updateQuantite(1)"
                                    class="w-12 h-12 border-2 border-gray-300 rounded-lg hover:border-gray-400 transition-colors flex items-center justify-center font-medium text-xl">
                                +
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Formulaire Ajouter au panier -->
                <form action="{{ route('cart.add', $premiereVariante->id_variant) }}" method="POST" id="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="quantite" id="form-quantite" value="1">
                    <button type="submit" 
                            class="w-full bg-gray-900 text-white py-4 rounded-lg hover:bg-black transition-colors font-medium text-lg flex items-center justify-center gap-2"
                            {{ $premiereVariante->quantite_stock < 1 ? 'disabled' : '' }}>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        {{ $premiereVariante->quantite_stock > 0 ? 'Ajouter au panier' : 'Rupture de stock' }}
                    </button>
                </form>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg">
                    <p class="text-gray-500 mb-4">Ce produit n'a pas de variantes disponibles</p>
                    <a href="{{ route('products.glasses') }}" class="text-gray-900 hover:underline">
                        Voir d'autres produits
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
let selectedVariant = @json($produit->variantes->first() ?? null);
let variants = @json($produit->variantes ?? []);

function selectCouleur(couleur) {
    // Trouver la première variante avec cette couleur
    const variant = variants.find(v => v.couleur === couleur);
    if (variant) {
        selectedVariant = variant;
        updateVariantDisplay();
    }
}

function selectTaille(taille) {
    // Trouver la variante avec cette taille
    const variant = variants.find(v => v.taille === taille);
    if (variant) {
        selectedVariant = variant;
        updateVariantDisplay();
    }
}

function updateVariantDisplay() {
    // Mettre à jour le stock
    document.getElementById('stock-display').textContent = selectedVariant.quantite_stock + ' en stock';
    
    // Mettre à jour la quantité max
    const quantiteInput = document.getElementById('quantite');
    quantiteInput.max = selectedVariant.quantite_stock;
    if (parseInt(quantiteInput.value) > selectedVariant.quantite_stock) {
        quantiteInput.value = selectedVariant.quantite_stock;
    }
    
    // Mettre à jour l'action du formulaire
    document.getElementById('add-to-cart-form').action = '{{ route("cart.add", "") }}/' + selectedVariant.id_variant;
    
    // Activer/désactiver le bouton
    const submitBtn = document.querySelector('#add-to-cart-form button[type="submit"]');
    if (selectedVariant.quantite_stock < 1) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Rupture de stock';
    } else {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg> Ajouter au panier';
    }
}

function updateQuantite(delta) {
    const input = document.getElementById('quantite');
    let newValue = parseInt(input.value) + delta;
    if (newValue < 1) newValue = 1;
    if (newValue > selectedVariant.quantite_stock) newValue = selectedVariant.quantite_stock;
    input.value = newValue;
    document.getElementById('form-quantite').value = newValue;
}

// Synchroniser les inputs de quantité
document.getElementById('quantite').addEventListener('input', function() {
    document.getElementById('form-quantite').value = this.value;
});
</script>
@endpush
@endsection