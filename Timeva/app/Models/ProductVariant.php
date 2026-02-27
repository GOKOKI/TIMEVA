<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color',
        'size',
        'stock_quantity',
        'image_url',
    ];

    protected $casts = [
        'stock_quantity' => 'integer',
    ];

    /**
     * Relation : appartient à un produit
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
