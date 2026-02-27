<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Profil;
use App\Models\Commande;
use App\Models\Panier;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relations avec les modèles personnalisés
     */
    
    // Relation 1:1 avec Profil
    public function profil(): HasOne
    {
        return $this->hasOne(Profil::class, 'user_id', 'id');
    }

    // Relation 1:N avec Commandes
    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class, 'user_id', 'id');
    }

    // Relation 1:N avec Panier
    public function panier(): HasMany
    {
        return $this->hasMany(Panier::class, 'user_id', 'id');
    }

    // Accesseur pour vérifier si l'utilisateur est admin
    public function getIsAdminAttribute(): bool
    {
        return $this->profil && $this->profil->role === 'admin';
    }

    // Accesseur pour obtenir le nom complet depuis le profil
    public function getNomCompletAttribute(): ?string
    {
        return $this->profil?->nom_complet;
    }

    // Scope pour les utilisateurs avec profil
    public function scopeAvecProfil($query)
    {
        return $query->has('profil');
    }

    // Scope pour les administrateurs
    public function scopeAdministrateurs($query)
    {
        return $query->whereHas('profil', function ($q) {
            $q->where('role', 'admin');
        });
    }
}