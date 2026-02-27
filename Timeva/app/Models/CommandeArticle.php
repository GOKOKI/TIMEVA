<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeArticle extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'commande_id',
        'nom_produit',
        'infos_variante',
        'quantite',
        'prix_unitaire',
        'total',
    ];

    protected $casts = [
        'infos_variante' => 'array',
        'prix_unitaire'  => 'decimal:2',
        'total'          => 'decimal:2',
    ];

    /**
     * Relation : appartient à une commande
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
