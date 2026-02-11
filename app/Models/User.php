<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\SuppressionDouce;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SuppressionDouce,SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'avatar',
        'role',
        'est_actif',
        'derniere_connexion',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'est_actif' => 'boolean',
        'derniere_connexion' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relation avec les sociétés
     */
    public function societes()
    {
        return $this->hasMany(Societe::class, 'user_id');
    }

    /**
     * Relation avec les activités
     */
    public function activites()
    {
        return $this->hasMany(Activite::class, 'user_id');
    }

    /**
     * Relation avec les documents
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    /**
     * Vérifier si l'utilisateur est administrateur
     */
    public function estAdministrateur()
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifier si l'utilisateur est actif
     */
    public function estActif()
    {
        return $this->est_actif === true;
    }


    /**
     * Obtenir les initiales pour l'avatar
     */
    public function getInitialesAttribute()
    {
        $mots = explode(' ', $this->name);
        $initiales = '';
        
        foreach ($mots as $mot) {
            if (!empty($mot)) {
                $initiales .= strtoupper(substr($mot, 0, 1));
            }
        }
        
        return substr($initiales, 0, 2);
    }
}