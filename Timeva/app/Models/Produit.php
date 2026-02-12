<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produits';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nom',
        'prix',
        'categorie',
        'marque',
        'description',
        'img',
        'disponible',
        'date_creation',
        'date_modification'
    ];

    protected $casts = [
        'id' => 'string',
        'prix' => 'decimal:2',
        'disponible' => 'boolean',
        'date_creation' => 'datetime',
        'date_modification' => 'datetime'
    ];

    protected $attributes = [
        'disponible' => true
    ];

    // Relations
    public function variantes(): HasMany
    {
        return $this->hasMany(VarianteProduit::class, 'id_produit', 'id');
    }

    // Scopes
    public function scopeDisponibles($query)
    {
        return $query->where('disponible', true);
    }

    public function scopeParCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    public function scopeParMarque($query, $marque)
    {
        return $query->where('marque', $marque);
    }
}