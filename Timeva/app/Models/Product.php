<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\ProductVariant;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'prix',
        'image',
        'category',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'prix'      => 'decimal:2',
    ];

    /**
     * Génération automatique du slug avant création
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Scope : produits actifs uniquement
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Relation : Un produit peut avoir plusieurs variantes (couleurs, tailles)
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}