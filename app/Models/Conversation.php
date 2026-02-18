<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Conversation extends Model
{
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'is_group',
        'name',
        'created_by',
        'last_message_at'
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array
     */
    protected $casts = [
        'is_group' => 'boolean',
        'last_message_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Les attributs à ajouter aux tableaux JSON.
     *
     * @var array
     */
    protected $appends = [
        'last_message_preview',
        'participants_count',
        'unread_count_for_current_user'
    ];

    // =========================================================================
    // RELATIONS
    // =========================================================================

    /**
     * Utilisateurs participant à la conversation
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    /**
     * Messages de la conversation
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Dernier message de la conversation
     */
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Créateur de la conversation (pour les groupes)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /**
     * Scope pour les conversations d'un utilisateur
     */
    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        });
    }

    /**
     * Scope pour les conversations avec messages non lus
     */
    public function scopeWithUnread($query, $userId)
    {
        return $query->whereHas('messages', function ($q) use ($userId) {
            $q->where('user_id', '!=', $userId)
              ->whereRaw('messages.created_at > (
                  SELECT last_read_at 
                  FROM conversation_user 
                  WHERE conversation_user.conversation_id = messages.conversation_id
                  AND conversation_user.user_id = ?
              )', [$userId]);
        });
    }

    /**
     * Scope pour les conversations groupées
     */
    public function scopeGroups($query)
    {
        return $query->where('is_group', true);
    }

    /**
     * Scope pour les conversations individuelles
     */
    public function scopeIndividual($query)
    {
        return $query->where('is_group', false);
    }

    // =========================================================================
    // ACCESSORS
    // =========================================================================

    /**
     * Obtenir le nom de la conversation
     */
    public function getNameAttribute($value)
    {
        if ($value) {
            return $value;
        }

        // Si c'est une conversation individuelle, utiliser le nom de l'autre utilisateur
        if (!$this->is_group) {
            $otherUser = $this->users()
                ->where('users.id', '!=', auth()->id())
                ->first();
            
            return $otherUser ? $otherUser->name : 'Conversation';
        }

        return 'Groupe sans nom';
    }

    /**
     * Obtenir l'avatar de la conversation
     */
    public function getAvatarAttribute()
    {
        if (!$this->is_group) {
            $otherUser = $this->users()
                ->where('users.id', '!=', auth()->id())
                ->first();
            
            return $otherUser ? $otherUser->avatar_url : asset('img/group.jpg');
        }

        // Pour les groupes, on pourrait avoir un avatar personnalisé
        return asset('img/group.jpg');
    }

    /**
     * Obtenir un aperçu du dernier message
     */
    public function getLastMessagePreviewAttribute()
    {
        $lastMessage = $this->lastMessage;
        
        if (!$lastMessage) {
            return 'Aucun message';
        }

        // Si c'est un fichier
        if ($lastMessage->file_path) {
            $fileName = $lastMessage->file_name ?? 'fichier';
            $fileIcon = $lastMessage->file_icon;
            
            return "📎 " . $fileName;
        }

        // Si c'est un texte
        $preview = $lastMessage->body;
        if (strlen($preview) > 30) {
            $preview = substr($preview, 0, 27) . '...';
        }

        return $preview;
    }

    /**
     * Obtenir le nombre de participants
     */
    public function getParticipantsCountAttribute()
    {
        return $this->users()->count();
    }

    /**
     * Obtenir le nombre de messages non lus pour l'utilisateur courant
     */
    public function getUnreadCountForCurrentUserAttribute()
    {
        if (!auth()->check()) {
            return 0;
        }

        $lastRead = $this->users()
            ->where('users.id', auth()->id())
            ->first()
            ->pivot
            ->last_read_at;

        if (!$lastRead) {
            return $this->messages()->where('user_id', '!=', auth()->id())->count();
        }

        return $this->messages()
            ->where('user_id', '!=', auth()->id())
            ->where('created_at', '>', $lastRead)
            ->count();
    }

    /**
     * Obtenir l'heure du dernier message formatée
     */
    public function getLastMessageTimeAttribute()
    {
        $lastMessage = $this->lastMessage;
        
        if (!$lastMessage) {
            return null;
        }

        $diff = now()->diffInDays($lastMessage->created_at);

        if ($diff < 1) {
            return $lastMessage->created_at->format('H:i');
        } elseif ($diff < 7) {
            return $lastMessage->created_at->format('l');
        } else {
            return $lastMessage->created_at->format('d/m/Y');
        }
    }

    // =========================================================================
    // MÉTHODES
    // =========================================================================

    /**
     * Ajouter des utilisateurs à la conversation
     */
    public function addUsers(array $userIds)
    {
        $this->users()->syncWithoutDetaching($userIds);
        
        Log::info('👥 Utilisateurs ajoutés à la conversation', [
            'conversation_id' => $this->id,
            'user_ids' => $userIds
        ]);
    }

    /**
     * Retirer des utilisateurs de la conversation
     */
    public function removeUsers(array $userIds)
    {
        $this->users()->detach($userIds);
        
        Log::info('👥 Utilisateurs retirés de la conversation', [
            'conversation_id' => $this->id,
            'user_ids' => $userIds
        ]);
    }

    /**
     * Marquer tous les messages comme lus pour un utilisateur
     */
    public function markAsReadForUser($userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        $this->users()->updateExistingPivot($userId, [
            'last_read_at' => now()
        ]);

        Log::info('👁️ Messages marqués comme lus', [
            'conversation_id' => $this->id,
            'user_id' => $userId
        ]);
    }

    /**
     * Vérifier si un utilisateur est dans la conversation
     */
    public function hasUser($userId)
    {
        return $this->users()->where('users.id', $userId)->exists();
    }

    /**
     * Obtenir l'autre utilisateur (pour conversations individuelles)
     */
    public function getOtherUser($userId = null)
    {
        if ($this->is_group) {
            return null;
        }

        $userId = $userId ?? auth()->id();

        return $this->users()
            ->where('users.id', '!=', $userId)
            ->first();
    }

    /**
     * Créer une conversation individuelle entre deux utilisateurs
     */
    public static function createIndividual($user1Id, $user2Id)
    {
        // Vérifier si une conversation existe déjà
        $existing = self::where('is_group', false)
            ->whereHas('users', function ($q) use ($user1Id) {
                $q->where('users.id', $user1Id);
            })
            ->whereHas('users', function ($q) use ($user2Id) {
                $q->where('users.id', $user2Id);
            })
            ->first();

        if ($existing) {
            return $existing;
        }

        // Créer nouvelle conversation
        $conversation = self::create([
            'is_group' => false,
            'created_by' => $user1Id
        ]);

        $conversation->users()->attach([$user1Id, $user2Id]);

        Log::info('💬 Nouvelle conversation individuelle', [
            'conversation_id' => $conversation->id,
            'user1_id' => $user1Id,
            'user2_id' => $user2Id
        ]);

        return $conversation;
    }

    /**
     * Créer une conversation de groupe
     */
    public static function createGroup($name, $creatorId, array $userIds)
    {
        $conversation = self::create([
            'is_group' => true,
            'name' => $name,
            'created_by' => $creatorId
        ]);

        // Ajouter tous les utilisateurs (y compris le créateur)
        $allUserIds = array_unique(array_merge([$creatorId], $userIds));
        $conversation->users()->attach($allUserIds);

        Log::info('👥 Nouveau groupe créé', [
            'conversation_id' => $conversation->id,
            'name' => $name,
            'user_count' => count($allUserIds)
        ]);

        return $conversation;
    }
}