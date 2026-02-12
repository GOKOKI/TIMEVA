<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profil extends Model
{
    use HasFactory;

    protected $table = 'profils';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'prenom',
        'nom',
        'tel',
        'adresse',
        'ville',
        'code_postal',
        'pays',
        'role',
        'date_creation',
        'date_modification'
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'date_creation' => 'datetime',
        'date_modification' => 'datetime'
    ];

    protected $attributes = [
        'pays' => 'France',
        'role' => 'user'
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class, 'user_id', 'user_id');
    }

    public function paniers(): HasMany
    {
        return $this->hasMany(Panier::class, 'user_id', 'user_id');
    }

    // Accesseurs
    public function getNomCompletAttribute(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }

    // Scopes
    public function scopeAdministrateurs($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeParVille($query, $ville)
    {
        return $query->where('ville', $ville);
    }
}