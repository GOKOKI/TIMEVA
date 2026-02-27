<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Commande extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'reference',
        'montant',
        'statut',
        'adresse_livraison',
        'code_postal',
        'pays_expedition',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($commande) {
            if (empty($commande->id)) {
                $commande->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Accesseur : date_creation pointe vers created_at
     */
    public function getDateCreationAttribute()
    {
        return $this->created_at;
    }

    /**
     * Relation : appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : articles de la commande
     */
    public function articles()
    {
        return $this->hasMany(CommandeArticle::class);
    }
}
