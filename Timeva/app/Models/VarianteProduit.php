<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VarianteProduit extends Model
{
    use HasFactory;

    protected $table = 'variantes_de_produit';
    protected $primaryKey = 'id_variant';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'id_variant',
        'id_produit',
        'couleur',
        'taille',
        'reference',
        'prix_modificateur', // Correction: prix_modificateur, pas prix
        'quantite_stock',
        'img',
        'date_creation',
        'date_modification'
    ];

    protected $casts = [
        'id_variant' => 'string',
        'id_produit' => 'string',
        'prix_modificateur' => 'decimal:2', // Correction
        'quantite_stock' => 'integer',
        'date_creation' => 'datetime',
        'date_modification' => 'datetime'
    ];

    protected $attributes = [
        'prix_modificateur' => 0, // Correction
        'quantite_stock' => 0
    ];

    // Relations
    public function produit(): BelongsTo // Correction: singulier
    {
        return $this->belongsTo(Produit::class, 'id_produit', 'id');
    }

    public function paniers(): HasMany
    {
        return $this->hasMany(Panier::class, 'variant_id', 'id_variant');
    }

    public function articlesCommandes(): HasMany
    {
        return $this->hasMany(ArticleCommande::class, 'variant_id', 'id_variant');
    }

    // Accesseurs
    public function getPrixFinalAttribute(): float
    {
        return $this->produit->prix + $this->prix_modificateur;
    }

    public function getEstDisponibleAttribute(): bool
    {
        return $this->quantite_stock > 0 && $this->produit->disponible;
    }

    // Scopes
    public function scopeEnStock($query)
    {
        return $query->where('quantite_stock', '>', 0);
    }

    public function scopeParCouleur($query, $couleur)
    {
        return $query->where('couleur', $couleur);
    }

    public function scopeParTaille($query, $taille)
    {
        return $query->where('taille', $taille);
    }
}