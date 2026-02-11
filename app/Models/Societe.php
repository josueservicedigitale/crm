<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Traits\LogsActivity;
use Intervention\Image\Color;


class Societe extends Model
{
    use HasFactory, SoftDeletes; // Ajoutez SoftDeletes
    
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'nom',
        'code',           // Renommé de 'slug' à 'code'
        'adresse',
        'telephone',
        'email',
        'ville',
        'code_postal',
        'siret',
        'tva_intracommunautaire',
        'logo_path',
        'est_active',    
        'couleur',       
        'icon',          
        'user_id'        
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
        static::creating(function ($societe) {
            if (empty($societe->code) && !empty($societe->nom)) {
                $societe->code = Str::slug($societe->nom);
            }

            // Par défaut, l'utilisateur connecté
            if (empty($societe->user_id) && auth()->check()) {
                $societe->user_id = auth()->id();
            }
        });

        // Met à jour le code si le nom change
        static::updating(function ($societe) {
            if ($societe->isDirty('nom') && empty($societe->code)) {
                $societe->code = Str::slug($societe->nom);
            }
        });
    }




    /**
     * Récupère les statistiques avec cache
     */
    public function getCachedStats(string $cacheKey = null, int $ttl = 3600): array
    {
        $cacheKey = $cacheKey ?: "societe_stats_{$this->id}";

        return Cache::remember($cacheKey, $ttl, function () {
            $total = $this->documents()->count();

            return [
                'total' => $total,
                'par_type' => $this->getDocumentsByType(),
                'par_activite' => $this->getDocumentsByActivity(),
                'chiffre_affaires' => $this->documents()->sum('montant_ttc'),
                'chiffre_affaires_moyen' => $total > 0 ? $this->documents()->avg('montant_ttc') : 0,
                'recent' => $this->documents()->latest()->limit(5)->get(),
                'dernier_mois' => $this->getLastMonthStats(),
            ];
        });
    }

    /**
     * Invalide le cache des statistiques
     */
    public function invalidateStatsCache(): void
    {
        Cache::forget("societe_stats_{$this->id}");
        Cache::forget("societe_evolution_{$this->id}");
    }
    // =========================================================================
    // RELATIONS
    // =========================================================================

    /**
     * Relation avec les documents
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'society', 'code');
    }

    /**
     * Relation many-to-many avec les activités
     */
    public function activites()
    {
        return $this->belongsToMany(Activite::class, 'activite_societe');
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
     * Scope pour les sociétés actives
     */
    public function scopeActive($query)
    {
        return $query->where('est_active', true);
    }

    /**
     * Scope pour les sociétés inactives
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
                ->orWhere('ville', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope pour les sociétés par ville
     */
    public function scopeByVille($query, $ville)
    {
        return $query->where('ville', $ville);
    }

    /**
     * Scope pour les sociétés d'un utilisateur
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
        return match ($this->code) {
            'nova' => 'Énergie Nova',
            'house' => 'MyHouse Solutions',
            default => $this->nom
        };
    }

    /**
     * Accessor pour l'adresse complète
     */
    public function getAdresseCompleteAttribute()
    {
        $parts = [];
        if ($this->adresse)
            $parts[] = $this->adresse;
        if ($this->code_postal)
            $parts[] = $this->code_postal;
        if ($this->ville)
            $parts[] = $this->ville;

        return implode(', ', $parts);
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
        return $this->icon ?? 'fa-building';
    }

    /**
     * Accessor pour l'URL du logo
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo_path) {
            return asset('storage/' . $this->logo_path);
        }

        // Logo par défaut basé sur le code
        return match ($this->code) {
            'nova' => asset('assets/img/nova/logo.png'),
            'house' => asset('assets/img/house/logo.png'),
            default => asset('assets/img/default-logo.png')
        };
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

    /**
     * Accessor pour le texte de la couleur contrastée (version améliorée)
     */
    public function getCouleurContrastAttribute(): string
    {
        if (!$this->couleur) {
            return '#000000';
        }

        try {
            $color = new Color($this->couleur);
            $r = $color->getRed();
            $g = $color->getGreen();
            $b = $color->getBlue();

            // Formule WCAG 2.1 pour la luminance relative
            $luminance = (0.2126 * $r + 0.7152 * $g + 0.0722 * $b) / 255;

            return $luminance > 0.5 ? '#000000' : '#FFFFFF';
        } catch (\Exception $e) {
            return '#000000';
        }
    }

    /**
     * Génère une palette de couleurs dérivées
     */
    public function getColorPaletteAttribute(): array
    {
        $baseColor = $this->couleur ?? '#3B82F6';

        return [
            'primary' => $baseColor,
            'light' => $this->lightenColor($baseColor, 30),
            'dark' => $this->darkenColor($baseColor, 30),
            'muted' => $this->desaturateColor($baseColor, 50),
        ];
    }

    /**
     * Éclaircit une couleur
     */
    protected function lightenColor(string $color, int $percent): string
    {
        // Implémentation de la logique d'éclaircissement
        return $color; // À implémenter
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
    /**
     * Récupère les statistiques détaillées
     */
    public function getStats(): array
    {
        $documents = $this->documents();
        $total = $documents->count();
        $totalMontant = $documents->sum('montant_ttc');

        return [
            'total_documents' => $total,
            'total_montant' => $totalMontant,
            'moyenne_montant' => $total > 0 ? round($totalMontant / $total, 2) : 0,
            'par_type' => $this->getDocumentsByType(),
            'par_activite' => $this->getDocumentsByActivity(),
            'par_mois' => $this->getMonthlyStats(12),
            'top_adresses' => $this->getTopAdresses(5),
            'evolution' => $this->getEvolutionStats(),
        ];
    }

    /**
     * Récupère les documents groupés par type
     */
    protected function getDocumentsByType(): array
    {
        return $this->documents()
            ->selectRaw('type, COUNT(*) as count, SUM(montant_ttc) as total')
            ->groupBy('type')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->type => [
                        'count' => $item->count,
                        'total' => $item->total,
                        'percentage' => 0 // À calculer
                    ]
                ];
            })
            ->toArray();
    }

    /**
     * Récupère les statistiques mensuelles
     */
    public function getMonthlyStats(int $months = 12): array
    {
        return $this->documents()
            ->selectRaw('
            YEAR(created_at) as year,
            MONTH(created_at) as month,
            COUNT(*) as count,
            SUM(montant_ttc) as total
        ')
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'period' => "{$item->month}/{$item->year}",
                    'count' => $item->count,
                    'total' => $item->total,
                ];
            })
            ->values()
            ->toArray();
    }
    /**
     * Active la société
     */
    public function activate(): bool
    {
        $this->est_active = true;
        return $this->save();
    }

    /**
     * Désactive la société
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
        if ($this->est_active && self::where('est_active', true)->count() <= 1) {
            // Ne rien faire, c'est la dernière active
            return false;
        }

        return $this->update([
            'est_active' => !$this->est_active
        ]);
    }


    /**
     * Vérifie si la société est active
     */
    public function isActive(): bool
    {
        return $this->est_active === true;
    }

    /**
     * Vérifie si la société peut être supprimée
     */
    public function canBeDeleted(): bool
    {
        return !$this->hasDocuments();
    }

    /**
     * Trouve une société par son code
     */
    public static function findByCode(string $code): ?self
    {
        return self::where('code', $code)->first();
    }

    /**
     * Trouve une société par son code ou échoue
     */
    public static function findByCodeOrFail(string $code): self
    {
        return self::where('code', $code)->firstOrFail();
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
                return [$societe->code => $societe->nom_formate];
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
            'adresse_complete' => $this->adresse_complete,
            'statut_formate' => $this->statut_formate,
            'statut_couleur' => $this->statut_couleur,
            'statut_icone' => $this->statut_icone,
            'icon_complete' => $this->icon_complete,
            'logo_url' => $this->logo_url,
            'couleur_style' => $this->couleur_style,
            'couleur_contrast' => $this->couleur_contrast,
            'has_documents' => $this->hasDocuments(),
            'documents_count' => $this->countDocuments(),
            'created_by' => $this->user ? $this->user->name : 'Inconnu',
            'created_at_formatted' => $this->created_at->format('d/m/Y H:i'),
        ]);
    }

    /**
     * Récupère les sociétés sous forme de tableau pour les selects
     */
    public static function forSelect(): array
    {
        return self::active()
            ->orderBy('nom')
            ->get()
            ->mapWithKeys(function ($societe) {
                return [
                    $societe->code => "{$societe->nom} ({$societe->code})"
                ];
            })
            ->toArray();
    }

    /**
     * Récupère les sociétés avec leur couleur pour affichage
     */
    public static function withColors(): array
    {
        return self::active()
            ->orderBy('nom')
            ->get()
            ->map(function ($societe) {
                return [
                    'code' => $societe->code,
                    'nom' => $societe->nom,
                    'couleur' => $societe->couleur,
                    'icon' => $societe->icon,
                    'logo_url' => $societe->logo_url,
                ];
            })
            ->toArray();
    }


    /**
     * Télécharge un nouveau logo
     */
    public function uploadLogo($file): bool
    {
        // Supprimer l'ancien logo
        $this->deleteLogo();

        // Enregistrer le nouveau
        $path = $file->store('logos/societes', 'public');
        $this->logo_path = $path;

        return $this->save();
    }

    /**
     * Supprime le logo
     */
    public function deleteLogo(): bool
    {
        if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
            Storage::disk('public')->delete($this->logo_path);
            $this->logo_path = null;
            return $this->save();
        }

        return false;
    }

    /**
     * Vérifie si un logo existe
     */
    public function hasLogo(): bool
    {
        return !empty($this->logo_path) && Storage::disk('public')->exists($this->logo_path);
    }
    /**
     * Synchronise les activités avec la société
     */
    public function syncActivites(array $activiteIds): void
    {
        $this->activites()->sync($activiteIds);
    }

    /**
     * Vérifie si la société a une activité spécifique
     */
    public function hasActivite($activiteId): bool
    {
        return $this->activites()->where('activite_id', $activiteId)->exists();
    }
}