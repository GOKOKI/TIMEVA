<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'statut',
        'montant',
        'adresse_livraison',
        'code_postal',
        'pays_expedition',
        'stripe_payment_id',
        'date_creation',
        'date_modification'
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'montant' => 'decimal:2',
        'date_creation' => 'datetime',
        'date_modification' => 'datetime'
    ];

    protected $attributes = [
        'statut' => 'en attente'
    ];

    // Constantes pour les statuts
    const STATUT_EN_ATTENTE = 'en attente';
    const STATUT_CONFIRME = 'confirmé';
    const STATUT_EXPEDIE = 'expédié';
    const STATUT_LIVRE = 'livré';
    const STATUT_ANNULE = 'annulé';

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class, 'user_id', 'user_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(ArticleCommande::class, 'commande_id', 'id');
    }

    // Scopes
    public function scopeEnAttente($query)
    {
        return $query->where('statut', self::STATUT_EN_ATTENTE);
    }

    public function scopeConfirmees($query)
    {
        return $query->where('statut', self::STATUT_CONFIRME);
    }

    public function scopeExpediees($query)
    {
        return $query->where('statut', self::STATUT_EXPEDIE);
    }

    public function scopeLivrees($query)
    {
        return $query->where('statut', self::STATUT_LIVRE);
    }

    public function scopeAnnulees($query)
    {
        return $query->where('statut', self::STATUT_ANNULE);
    }

    // Méthodes
    public function estPayee(): bool
    {
        return !in_array($this->statut, [self::STATUT_EN_ATTENTE, self::STATUT_ANNULE]);
    }

    public function peutEtreAnnulee(): bool
    {
        return in_array($this->statut, [self::STATUT_EN_ATTENTE, self::STATUT_CONFIRME]);
    }
}