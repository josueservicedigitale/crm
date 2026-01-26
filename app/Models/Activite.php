<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activite extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'statut'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Génère automatiquement le slug avant la création
        static::creating(function ($activite) {
            if (empty($activite->slug) && !empty($activite->nom)) {
                $activite->slug = Str::slug($activite->nom);
            }
        });

        // Met à jour le slug si le nom change
        static::updating(function ($activite) {
            if ($activite->isDirty('nom') && empty($activite->slug)) {
                $activite->slug = Str::slug($activite->nom);
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
        return $this->hasMany(Document::class, 'activity', 'slug');
    }

    /**
     * Relation many-to-many avec les sociétés
     */
    public function societes()
    {
        return $this->belongsToMany(Societe::class, 'activite_societe');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /**
     * Scope pour les activités actives
     */
    public function scopeActive($query)
    {
        return $query->where('statut', 'actif');
    }

    /**
     * Scope pour les activités inactives
     */
    public function scopeInactive($query)
    {
        return $query->where('statut', 'inactif');
    }

    /**
     * Scope pour rechercher par nom ou slug
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nom', 'LIKE', "%{$search}%")
              ->orWhere('slug', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    // =========================================================================
    // ACCESSORS & MUTATORS
    // =========================================================================

    /**
     * Accessor pour le nom formaté
     */
    public function getNomFormateAttribute()
    {
        return match($this->slug) {
            'desembouage' => 'Désembouage',
            'reequilibrage' => 'Rééquilibrage',
            default => $this->nom
        };
    }

    /**
     * Accessor pour le statut formaté
     */
    public function getStatutFormateAttribute()
    {
        return match($this->statut) {
            'actif' => 'Actif',
            'inactif' => 'Inactif',
            default => ucfirst($this->statut)
        };
    }

    /**
     * Accessor pour la couleur du statut
     */
    public function getStatutCouleurAttribute()
    {
        return match($this->statut) {
            'actif' => 'success',
            'inactif' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Accessor pour l'icône du statut
     */
    public function getStatutIconeAttribute()
    {
        return match($this->statut) {
            'actif' => 'fa-check-circle',
            'inactif' => 'fa-times-circle',
            default => 'fa-question-circle'
        };
    }

    /**
     * Mutator pour assurer un slug valide
     */
    public function setSlugAttribute($value)
    {
        // Si une valeur est fournie, on la transforme en slug
        if ($value) {
            $this->attributes['slug'] = Str::slug($value);
        }
        // Sinon, on utilise le nom (sera géré par le boot() si nom existe)
        elseif ($this->nom && !$this->slug) {
            $this->attributes['slug'] = Str::slug($this->nom);
        }
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
    public function activate(): void
    {
        $this->update(['statut' => 'actif']);
    }

    /**
     * Désactive l'activité
     */
    public function deactivate(): void
    {
        $this->update(['statut' => 'inactif']);
    }

    /**
     * Vérifie si l'activité est active
     */
    public function isActive(): bool
    {
        return $this->statut === 'actif';
    }

    /**
     * Vérifie si l'activité peut être supprimée
     */
    public function canBeDeleted(): bool
    {
        return !$this->hasDocuments();
    }

    /**
     * Trouve une activité par son slug
     */
    public static function findBySlug(string $slug): ?self
    {
        return self::where('slug', $slug)->first();
    }

    /**
     * Trouve une activité par son slug ou échoue
     */
    public static function findBySlugOrFail(string $slug): self
    {
        return self::where('slug', $slug)->firstOrFail();
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
                return [$activite->slug => $activite->nom_formate];
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
            'has_documents' => $this->hasDocuments(),
            'documents_count' => $this->countDocuments(),
        ]);
    }
}