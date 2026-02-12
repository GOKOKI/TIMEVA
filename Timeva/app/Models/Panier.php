<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Panier extends Model
{
    use HasFactory;

    protected $table = 'panier';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'variant_id',
        'quantite',
        'date_creation',
        'date_modification'
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'variant_id' => 'string',
        'quantite' => 'integer',
        'date_creation' => 'datetime',
        'date_modification' => 'datetime'
    ];

    protected $attributes = [
        'quantite' => 1
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class, 'user_id', 'user_id');
    }

    public function variante(): BelongsTo
    {
        return $this->belongsTo(VarianteProduit::class, 'variant_id', 'id_variant');
    }

    // Accesseurs
    public function getSousTotalAttribute(): float
    {
        return $this->variante->prix_final * $this->quantite;
    }

        // ✅ Accesseur pour l'image (via la variante)
    public function getImageAttribute(): ?string
    {
        return $this->variante?->image;
    }

    // Scopes
    public function scopeParUtilisateur($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}