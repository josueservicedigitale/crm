<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\SuppressionDouce;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Conversation;
use App\Models\Message;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SuppressionDouce, SoftDeletes;

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
        'last_active_at' => 'datetime',
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



    /**
     * Vérifie si l'utilisateur est en ligne (actif dans les 5 dernières minutes)
     */
    public function isOnline(): bool
    {
        if (!$this->last_active_at) {
            return false;
        }

        $lastActive = $this->last_active_at instanceof \Carbon\Carbon
            ? $this->last_active_at
            : \Carbon\Carbon::parse($this->last_active_at);

        return $lastActive->gt(now()->subMinutes(5));
    }

    /**
     * Conversations de l'utilisateur
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class)->withPivot('last_read_at')->withTimestamps();
    }

    /**
     * Messages non lus dans toutes les conversations
     */
    public function unreadMessagesCount()
    {
        return Message::whereHas('conversation', function ($q) {
            $q->whereHas('users', function ($q2) {
                $q2->where('users.id', $this->id);
            });
        })
            ->where('user_id', '!=', $this->id)
            ->whereRaw('messages.created_at > (
            SELECT last_read_at 
            FROM conversation_user 
            WHERE conversation_user.conversation_id = messages.conversation_id
            AND conversation_user.user_id = ?
        )', [$this->id])
            ->count();
    }

    /**
     * Canal privé pour l'utilisateur
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'private-user.' . $this->id;
    }

}