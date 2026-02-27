@extends('layout.app')

{{-- On utilise 'name' au lieu de 'nom' --}}
@section('title', $product->name ?? 'Détail produit')

@section('content')
<div class="container py-5">

    <div class="row">
        {{-- Image du produit --}}
        <div class="col-md-6 mb-4">
            {{-- Utilisation du champ 'image' et de la marque 'brand' --}}
            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.jpg') }}"
                 class="img-fluid rounded shadow-sm"
                 alt="{{ $product->name }}">
        </div>

        {{-- Détails du produit --}}
        <div class="col-md-6">
            <span class="badge bg-secondary mb-2">{{ ucfirst($product->category) }}</span>
            <h1 class="display-5 fw-bold">{{ $product->name }}</h1>
            
            @if($product->brand)
                <p class="text-muted">Marque : <strong>{{ $product->brand }}</strong></p>
            @endif

            <h3 class="text-primary my-3">
                {{ number_format($product->prix, 2, ',', ' ') }} €
            </h3>

            <p class="lead">
                {{ $product->description }}
            </p>

            {{-- Gestion des Variantes --}}
            @if($product->variants && $product->variants->count())
                <hr>
                <h5 class="mb-3">Choisir une option :</h5>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    @foreach($product->variants as $variant)
                        <button type="button"
                                class="btn btn-outline-dark variant-btn"
                                onclick="selectVariant(event, {{ $variant->id }}, {{ $variant->stock_quantity }})">
                            {{ $variant->color ?? $variant->size ?? 'Option' }}
                        </button>
                    @endforeach
                </div>

                <p class="small">
                    Disponibilité : 
                    <span id="stock-display" class="fw-bold text-muted">Sélectionnez une option</span>
                </p>
            @endif

            {{-- Formulaire d'ajout au panier --}}
            <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variant_id" id="selected_variant_id">

                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="quantity" class="col-form-label">Quantité :</label>
                    </div>
                    <div class="col-auto">
                        <input type="number"
                               name="quantity"
                               id="quantity_input"
                               value="1"
                               min="1"
                               class="form-control"
                               style="width:80px;">
                    </div>
                </div>

                <button type="submit" 
                        class="btn btn-dark btn-lg mt-4 w-100"
                        id="addToCartBtn"
                        {{ $product->variants->count() ? 'disabled' : '' }}>
                    <i class="bi bi-cart-plus"></i> Ajouter au panier
                </button>
            </form>
        </div>
    </div>

    {{-- Produits similaires --}}
    @if(isset($similaires) && $similaires->count())
        <div class="mt-5">
            <hr class="my-5">
            <h3 class="mb-4">Vous aimerez aussi</h3>
            <div class="row">
                @foreach($similaires as $item)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/default.jpg') }}"
                                 class="card-img-top"
                                 alt="{{ $item->name }}">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ $item->name }}</h6>
                                <p class="text-primary fw-bold">{{ number_format($item->prix, 2, ',', ' ') }} €</p>
                                <a href="{{ route('products.show', $item->slug) }}"
                                   class="btn btn-sm btn-dark">Voir le produit</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    function selectVariant(event, id, stock) {
        // Gestion visuelle des boutons
        document.querySelectorAll('.variant-btn').forEach(btn => btn.classList.remove('active', 'btn-dark'));
        document.querySelectorAll('.variant-btn').forEach(btn => btn.classList.add('btn-outline-dark'));
        
        event.target.classList.remove('btn-outline-dark');
        event.target.classList.add('active', 'btn-dark');

        // Mise à jour des infos
        document.getElementById('selected_variant_id').value = id;
        document.getElementById('stock-display').innerText = stock > 0 ? stock + " en stock" : "Rupture de stock";
        document.getElementById('stock-display').className = stock > 0 ? "fw-bold text-success" : "fw-bold text-danger";
        
        // Limiter la quantité max selon le stock
        const qtyInput = document.getElementById('quantity_input');
        qtyInput.max = stock;
        if(qtyInput.value > stock) qtyInput.value = stock;

        // Activer/Désactiver le bouton
        document.getElementById('addToCartBtn').disabled = (stock <= 0);
    }
</script>
@endsection