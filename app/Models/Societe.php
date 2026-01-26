<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Societe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'adresse',
        'telephone',
        'email',
        'ville',
        'code_postal',
        'siret',
        'tva_intracommunautaire',
        'logo_path',
        'statut'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Génère automatiquement le slug avant la création
        static::creating(function ($societe) {
            if (empty($societe->slug) && !empty($societe->nom)) {
                $societe->slug = Str::slug($societe->nom);
            }
        });

        // Met à jour le slug si le nom change
        static::updating(function ($societe) {
            if ($societe->isDirty('nom') && empty($societe->slug)) {
                $societe->slug = Str::slug($societe->nom);
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
        return $this->hasMany(Document::class, 'society', 'slug');
    }

    /**
     * Relation many-to-many avec les activités
     */
    public function activites()
    {
        return $this->belongsToMany(Activite::class, 'activite_societe');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /**
     * Scope pour les sociétés actives
     */
    public function scopeActive($query)
    {
        return $query->where('statut', 'actif');
    }

    /**
     * Scope pour les sociétés inactives
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
              ->orWhere('adresse', 'LIKE', "%{$search}%")
              ->orWhere('ville', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
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
            'nova' => 'Énergie Nova',
            'house' => 'MyHouse Solutions',
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
     * Accessor pour l'adresse complète
     */
    public function getAdresseCompleteAttribute()
    {
        $parts = [];
        if ($this->adresse) $parts[] = $this->adresse;
        if ($this->code_postal) $parts[] = $this->code_postal;
        if ($this->ville) $parts[] = $this->ville;
        
        return $parts ? implode(', ', $parts) : null;
    }

    /**
     * Accessor pour l'URL du logo
     */
    public function getLogoUrlAttribute()
    {
        if (!$this->logo_path) {
            return null;
        }

        if (Str::startsWith($this->logo_path, ['http://', 'https://'])) {
            return $this->logo_path;
        }

        return asset('storage/' . $this->logo_path);
    }

    /**
     * Mutator pour assurer un slug valide
     */
    public function setSlugAttribute($value)
    {
        if ($value) {
            $this->attributes['slug'] = Str::slug($value);
        } elseif ($this->nom && !$this->slug) {
            $this->attributes['slug'] = Str::slug($this->nom);
        }
    }

    /**
     * Mutator pour formater le téléphone
     */
    public function setTelephoneAttribute($value)
    {
        if ($value) {
            // Nettoie le numéro de téléphone
            $cleaned = preg_replace('/[^0-9]/', '', $value);
            $this->attributes['telephone'] = $cleaned;
        }
    }

    /**
     * Accessor pour formater le téléphone à l'affichage
     */
    public function getTelephoneFormateAttribute()
    {
        if (!$this->telephone) {
            return null;
        }

        $phone = $this->telephone;
        if (strlen($phone) === 10) {
            return preg_replace('/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1 $2 $3 $4 $5', $phone);
        }

        return $phone;
    }

    // =========================================================================
    // MÉTHODES
    // =========================================================================

    /**
     * Vérifie si la société a des documents
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
     * Récupère les statistiques de la société
     */
    public function getStats(): array
    {
        $total = $this->documents()->count();
        
        return [
            'total' => $total,
            'par_activite' => $this->documents()
                ->selectRaw('activity, COUNT(*) as count')
                ->groupBy('activity')
                ->pluck('count', 'activity')
                ->toArray(),
            'par_type' => $this->documents()
                ->selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type')
                ->toArray(),
            'montant_total' => $this->documents()->sum('montant_ttc'),
            'recent' => $this->documents()
                ->latest()
                ->limit(5)
                ->get()
        ];
    }

    /**
     * Active la société
     */
    public function activate(): void
    {
        $this->update(['statut' => 'actif']);
    }

    /**
     * Désactive la société
     */
    public function deactivate(): void
    {
        $this->update(['statut' => 'inactif']);
    }

    /**
     * Vérifie si la société est active
     */
    public function isActive(): bool
    {
        return $this->statut === 'actif';
    }

    /**
     * Vérifie si la société peut être supprimée
     */
    public function canBeDeleted(): bool
    {
        return !$this->hasDocuments();
    }

    /**
     * Trouve une société par son slug
     */
    public static function findBySlug(string $slug): ?self
    {
        return self::where('slug', $slug)->first();
    }

    /**
     * Trouve une société par son slug ou échoue
     */
    public static function findBySlugOrFail(string $slug): self
    {
        return self::where('slug', $slug)->firstOrFail();
    }

    /**
     * Récupère toutes les sociétés actives
     */
    public static function getActiveList(): array
    {
        return self::active()
            ->orderBy('nom')
            ->get()
            ->mapWithKeys(function ($societe) {
                return [$societe->slug => $societe->nom_formate];
            })
            ->toArray();
    }

    /**
     * Formate la société pour l'affichage
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'nom_formate' => $this->nom_formate,
            'statut_formate' => $this->statut_formate,
            'statut_couleur' => $this->statut_couleur,
            'adresse_complete' => $this->adresse_complete,
            'telephone_formate' => $this->telephone_formate,
            'logo_url' => $this->logo_url,
            'has_documents' => $this->hasDocuments(),
            'documents_count' => $this->countDocuments(),
        ]);
    }
}