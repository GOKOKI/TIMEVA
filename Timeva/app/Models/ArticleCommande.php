<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ArticleCommande extends Model
{
    use HasFactory;

    protected $table = 'articles_commandes';
    protected $primaryKey = 'id_article';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'id_article',
        'commande_id',
        'variant_id',
        'nom_produit',
        'infos_variante', // ✅ Peut contenir l'URL de l'image au moment de l'achat
        'prix_unitaire',
        'quantite',
        'date_creation'
    ];

    protected $casts = [
        'id_article' => 'string',
        'commande_id' => 'string',
        'variant_id' => 'string',
        'prix_unitaire' => 'decimal:2',
        'quantite' => 'integer',
        'date_creation' => 'datetime'
    ];

    // Relations
    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande_id', 'id');
    }

    public function variante(): BelongsTo
    {
        return $this->belongsTo(VarianteProduit::class, 'variant_id', 'id_variant');
    }

    // Accesseurs
    public function getTotalAttribute(): float
    {
        return $this->prix_unitaire * $this->quantite;
    }

    // ✅ Accesseur pour l'image (au moment de la commande)
    public function getImageAttribute(): ?string
    {
        // Si 'infos_variante' contient du JSON avec l'image
        $infos = json_decode($this->infos_variante, true);
        return $infos['img'] ?? $this->variante?->image;
    }

    // Scopes
    public function scopeParCommande($query, $commandeId)
    {
        return $query->where('commande_id', $commandeId);
    }
}