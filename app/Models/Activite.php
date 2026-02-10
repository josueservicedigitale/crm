<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // AJOUTEZ CETTE LIGNE

class Activite extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nom',
        'code',           // Renommé de 'slug' à 'code'
        'description',
        'est_active',     // Changé de 'statut' à 'est_active' (boolean)
        'couleur',        // Nouveau champ
        'icon',           // Nouveau champ
        'user_id'         // Nouveau champ
    ];

    protected $casts = [
        'est_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Génère automatiquement le code avant la création
        static::creating(function ($activite) {
            if (empty($activite->code) && !empty($activite->nom)) {
                $activite->code = Str::slug($activite->nom);
            }
            
            // Par défaut, l'utilisateur connecté
            if (empty($activite->user_id) && auth()->check()) {
                $activite->user_id = auth()->id();
            }
        });

        // Met à jour le code si le nom change
        static::updating(function ($activite) {
            if ($activite->isDirty('nom') && empty($activite->code)) {
                $activite->code = Str::slug($activite->nom);
            }
        });
    }

    // =========================================================================
    // RELATIONS
    // =========================================================================

    /**
     * Relation avec les documents
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'activity', 'code');
    }

    /**
     * Relation many-to-many avec les sociétés
     */
    public function societes()
    {
        return $this->belongsToMany(Societe::class, 'activite_societe');
    }

    /**
     * Relation avec l'utilisateur créateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /**
     * Scope pour les activités actives
     */
    public function scopeActive($query)
    {
        return $query->where('est_active', true);
    }

    /**
     * Scope pour les activités inactives
     */
    public function scopeInactive($query)
    {
        return $query->where('est_active', false);
    }

    /**
     * Scope pour rechercher par nom ou code
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nom', 'LIKE', "%{$search}%")
              ->orWhere('code', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope pour les activités avec couleur spécifique
     */
    public function scopeByCouleur($query, $couleur)
    {
        return $query->where('couleur', $couleur);
    }

    /**
     * Scope pour les activités d'un utilisateur
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // =========================================================================
    // ACCESSORS & MUTATORS
    // =========================================================================

    /**
     * Accessor pour le nom formaté
     */
    public function getNomFormateAttribute()
    {
        return match($this->code) {
            'desembouage' => 'Désembouage',
            'reequilibrage' => 'Rééquilibrage',
            'maintenance-chaudiere' => 'Maintenance Chaudière',
            default => $this->nom
        };
    }

    /**
     * Accessor pour le statut formaté
     */
    public function getStatutFormateAttribute()
    {
        return $this->est_active ? 'Actif' : 'Inactif';
    }

    /**
     * Accessor pour la couleur du statut
     */
    public function getStatutCouleurAttribute()
    {
        return $this->est_active ? 'success' : 'secondary';
    }

    /**
     * Accessor pour l'icône du statut
     */
    public function getStatutIconeAttribute()
    {
        return $this->est_active ? 'fa-toggle-on' : 'fa-toggle-off';
    }

    /**
     * Accessor pour l'icône complète (FontAwesome)
     */
    public function getIconeCompleteAttribute()
    {
        return $this->icon ?? 'fa-tools';
    }

    /**
     * Accessor pour le style CSS de la couleur
     */
    public function getCouleurStyleAttribute()
    {
        return "background-color: {$this->couleur}; color: white;";
    }

    /**
     * Accessor pour le texte de la couleur contrastée
     */
    public function getCouleurContrastAttribute()
    {
        // Fonction simple pour déterminer si le texte doit être clair ou foncé
        $hex = str_replace('#', '', $this->couleur);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        // Formule de luminance
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        
        return $luminance > 0.5 ? '#000000' : '#FFFFFF';
    }

    /**
     * Mutator pour assurer un code valide
     */
    public function setCodeAttribute($value)
    {
        // Si une valeur est fournie, on la transforme en slug
        if ($value) {
            $this->attributes['code'] = Str::slug($value);
        }
        // Sinon, on utilise le nom (sera géré par le boot() si nom existe)
        elseif ($this->nom && !$this->code) {
            $this->attributes['code'] = Str::slug($this->nom);
        }
    }

    /**
     * Mutator pour la couleur (s'assure qu'elle commence par #)
     */
    public function setCouleurAttribute($value)
    {
        if (!empty($value) && !str_starts_with($value, '#')) {
            $value = '#' . $value;
        }
        $this->attributes['couleur'] = $value;
    }

    /**
     * Mutator pour l'icône (s'assure qu'elle a le préfixe 'fa-')
     */
    public function setIconAttribute($value)
    {
        if (!empty($value) && !str_starts_with($value, 'fa-')) {
            $value = 'fa-' . $value;
        }
        $this->attributes['icon'] = $value;
    }

    // =========================================================================
    // MÉTHODES
    // =========================================================================

    /**
     * Vérifie si l'activité a des documents
     */
    public function hasDocuments(): bool
    {
        return $this->documents()->exists();
    }

    /**
     * Compte le nombre de documents
     */
    public function countDocuments(): int
    {
        return $this->documents()->count();
    }

    /**
     * Récupère les statistiques de l'activité
     */
    public function getStats(): array
    {
        $total = $this->documents()->count();
        
        return [
            'total' => $total,
            'par_type' => $this->documents()
                ->selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type')
                ->toArray(),
            'par_societe' => $this->documents()
                ->selectRaw('society, COUNT(*) as count')
                ->groupBy('society')
                ->pluck('count', 'society')
                ->toArray(),
            'recent' => $this->documents()
                ->latest()
                ->limit(5)
                ->get()
        ];
    }

    /**
     * Active l'activité
     */
    public function activate(): bool
    {
        $this->est_active = true;
        return $this->save();
    }

    /**
     * Désactive l'activité
     */
    public function deactivate(): bool
    {
        $this->est_active = false;
        return $this->save();
    }

    /**
     * Bascule l'état actif/inactif
     */
  public function toggleStatus(): bool
{
    return self::where('id', $this->id)
        ->update(['est_active' => DB::raw('NOT est_active')]) === 1;
}

    /**
     * Vérifie si l'activité est active
     */
    public function isActive(): bool
    {
        return $this->est_active === true;
    }

    /**
     * Vérifie si l'activité peut être supprimée
     */
    public function canBeDeleted(): bool
    {
        return !$this->hasDocuments();
    }

    /**
     * Trouve une activité par son code
     */
    public static function findByCode(string $code): ?self
    {
        return self::where('code', $code)->first();
    }

    /**
     * Trouve une activité par son code ou échoue
     */
    public static function findByCodeOrFail(string $code): self
    {
        return self::where('code', $code)->firstOrFail();
    }

    /**
     * Récupère toutes les activités actives
     */
    public static function getActiveList(): array
    {
        return self::active()
            ->orderBy('nom')
            ->get()
            ->mapWithKeys(function ($activite) {
                return [$activite->code => $activite->nom_formate];
            })
            ->toArray();
    }

    /**
     * Formate l'activité pour l'affichage
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'nom_formate' => $this->nom_formate,
            'statut_formate' => $this->statut_formate,
            'statut_couleur' => $this->statut_couleur,
            'statut_icone' => $this->statut_icone,
            'icon_complete' => $this->icon_complete,
            'couleur_style' => $this->couleur_style,
            'couleur_contrast' => $this->couleur_contrast,
            'has_documents' => $this->hasDocuments(),
            'documents_count' => $this->countDocuments(),
            'created_by' => $this->user ? $this->user->name : 'Inconnu',
            'created_at_formatted' => $this->created_at->format('d/m/Y H:i'),
        ]);
    }

    /**
     * Récupère les activités sous forme de tableau pour les selects
     */
    public static function forSelect(): array
    {
        return self::active()
            ->orderBy('nom')
            ->get()
            ->mapWithKeys(function ($activite) {
                return [
                    $activite->code => "{$activite->nom} ({$activite->code})"
                ];
            })
            ->toArray();
    }

    /**
     * Récupère les activités avec leur couleur pour affichage
     */
    public static function withColors(): array
    {
        return self::active()
            ->orderBy('nom')
            ->get()
            ->map(function ($activite) {
                return [
                    'code' => $activite->code,
                    'nom' => $activite->nom,
                    'couleur' => $activite->couleur,
                    'icon' => $activite->icon,
                    'description' => $activite->description,
                ];
            })
            ->toArray();
    }
}