<?php


// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Cache;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Intervention\Image\Color;
// use Illuminate\Support\Facades\DB;


// class Societe extends Model
// {
//     use HasFactory, SoftDeletes;

//     protected $fillable = [
//         'nom',
//         'code',           // Renommé de 'slug' à 'code'
//         'adresse',
//         'telephone',
//         'email',
//         'ville',
//         'code_postal',
//         'siret',
//         'tva_intracommunautaire',
//         'logo_path',
//         'est_active',    
//         'couleur',       
//         'icon',          
//         'user_id'        
//     ];

//     protected $casts = [
//         'est_active' => 'boolean',
//         'created_at' => 'datetime',
//         'updated_at' => 'datetime',
//         'deleted_at' => 'datetime',
//     ];

//     /**
//      * Boot the model
//      */
//     protected static function boot()
//     {
//         parent::boot();

        
//         static::creating(function ($societe) {
//             if (empty($societe->code) && !empty($societe->nom)) {
//                 $societe->code = Str::slug($societe->nom);
//             }

//             if (empty($societe->user_id) && auth()->check()) {
//                 $societe->user_id = auth()->id();
//             }
//         });

        
//         static::updating(function ($societe) {
//             if ($societe->isDirty('nom') && empty($societe->code)) {
//                 $societe->code = Str::slug($societe->nom);
//             }
//         });
//     }

// public function getDocumentsByActivity(): array
// {
//     return $this->documents()
//         ->select('activity', DB::raw('COUNT(*) as count'), DB::raw('SUM(montant_ttc) as total'))
//         ->whereNotNull('activity')
//         ->groupBy('activity')
//         ->get()
//         ->mapWithKeys(function ($item) {
//             return [
//                 $item->activity => [
//                     'count' => $item->count,
//                     'total' => $item->total ?? 0,
//                     'percentage' => 0 // Sera calculé si besoin
//                 ]
//             ];
//         })
//         ->toArray();
// }

// public function getTopAdresses(int $limit = 5): array
// {
//     return $this->documents()
//         ->whereNotNull('adresse_travaux')
//         ->where('adresse_travaux', '!=', '')
//         ->select('adresse_travaux', DB::raw('COUNT(*) as count'))
//         ->groupBy('adresse_travaux')
//         ->orderByDesc('count')
//         ->limit($limit)
//         ->get()
//         ->mapWithKeys(function ($item) {
//             return [
//                 $item->adresse_travaux => [
//                     'count' => $item->count,
//                     'adresse' => $item->adresse_travaux
//                 ]
//             ];
//         })
//         ->toArray();
// }


// public function getEvolutionStats(int $months = 12): array
// {
//     return $this->documents()
//         ->select(
//             DB::raw('DATE_FORMAT(created_at, "%Y-%m") as period'),
//             DB::raw('COUNT(*) as count'),
//             DB::raw('SUM(montant_ttc) as total')
//         )
//         ->where('created_at', '>=', now()->subMonths($months))
//         ->groupBy('period')
//         ->orderBy('period', 'asc')
//         ->get()
//         ->map(function ($item) {
//             return [
//                 'period' => $item->period,
//                 'count' => (int) $item->count,
//                 'total' => (float) ($item->total ?? 0),
//             ];
//         })
//         ->toArray();
// }

// public function getLastMonthStats(): array
// {
//     $lastMonth = now()->subMonth();
    
//     $documents = $this->documents()
//         ->whereYear('created_at', $lastMonth->year)
//         ->whereMonth('created_at', $lastMonth->month);
    
//     $total = $documents->count();
//     $totalMontant = $documents->sum('montant_ttc');
    
//     return [
//         'month' => $lastMonth->translatedFormat('F Y'),
//         'year' => $lastMonth->year,
//         'month_num' => $lastMonth->month,
//         'total_documents' => $total,
//         'total_montant' => $totalMontant,
//         'moyenne_montant' => $total > 0 ? round($totalMontant / $total, 2) : 0,
//         'par_type' => $documents->select('type', DB::raw('COUNT(*) as count'))
//             ->groupBy('type')
//             ->pluck('count', 'type')
//             ->toArray(),
//     ];
// }

// public function calculatePercentages(array $stats): array
// {
//     $total = $stats['total_documents'] ?? 0;
    
//     if ($total > 0 && isset($stats['par_type'])) {
//         foreach ($stats['par_type'] as $type => &$data) {
//             if (is_array($data)) {
//                 $data['percentage'] = round(($data['count'] / $total) * 100, 1);
//             }
//         }
//     }
    
//     if ($total > 0 && isset($stats['par_activite'])) {
//         foreach ($stats['par_activite'] as $activite => &$data) {
//             if (is_array($data)) {
//                 $data['percentage'] = round(($data['count'] / $total) * 100, 1);
//             }
//         }
//     }
    
//     return $stats;
// }

//     public function getCachedStats(string $cacheKey = null, int $ttl = 3600): array
//     {
//         $cacheKey = $cacheKey ?: "societe_stats_{$this->id}";

//         return Cache::remember($cacheKey, $ttl, function () {
//             $total = $this->documents()->count();

//             return [
//                 'total' => $total,
//                 'par_type' => $this->getDocumentsByType(),
//                 'par_activite' => $this->getDocumentsByActivity(),
//                 'chiffre_affaires' => $this->documents()->sum('montant_ttc'),
//                 'chiffre_affaires_moyen' => $total > 0 ? $this->documents()->avg('montant_ttc') : 0,
//                 'recent' => $this->documents()->latest()->limit(5)->get(),
//                 'dernier_mois' => $this->getLastMonthStats(),
//             ];
//         });
//     }

//     public function invalidateStatsCache(): void
//     {
//         Cache::forget("societe_stats_{$this->id}");
//         Cache::forget("societe_evolution_{$this->id}");
//     }
 
//     public function documents()
//     {
//         return $this->hasMany(Document::class, 'society', 'code');
//     }

  
//     public function activites()
//     {
//         return $this->belongsToMany(Activite::class, 'activite_societe');
//     }

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }

//     public function scopeActive($query)
//     {
//         return $query->where('est_active', true);
//     }

  
//     public function scopeInactive($query)
//     {
//         return $query->where('est_active', false);
//     }

//     public function scopeSearch($query, $search)
//     {
//         return $query->where(function ($q) use ($search) {
//             $q->where('nom', 'LIKE', "%{$search}%")
//                 ->orWhere('code', 'LIKE', "%{$search}%")
//                 ->orWhere('ville', 'LIKE', "%{$search}%")
//                 ->orWhere('email', 'LIKE', "%{$search}%");
//         });
//     }

   
//     public function scopeByVille($query, $ville)
//     {
//         return $query->where('ville', $ville);
//     }

    
//     public function scopeByUser($query, $userId)
//     {
//         return $query->where('user_id', $userId);
//     }

 
//     public function getNomFormateAttribute()
//     {
//         return match ($this->code) {
//             'nova' => 'Énergie Nova',
//             'house' => 'MyHouse Solutions',
//             'patrimoine' => 'Patrimoine Immobilier', // 🏛️ NOUVEAU !
//         'patrimoine_immobilier' => 'Patrimoine Immobilier',
//         default => $this->nom
//         };
//     }

//     public function getAdresseCompleteAttribute()
//     {
//         $parts = [];
//         if ($this->adresse)
//             $parts[] = $this->adresse;
//         if ($this->code_postal)
//             $parts[] = $this->code_postal;
//         if ($this->ville)
//             $parts[] = $this->ville;

//         return implode(', ', $parts);
//     }

//     public function getStatutFormateAttribute()
//     {
//         return $this->est_active ? 'Actif' : 'Inactif';
//     }

//     public function getStatutCouleurAttribute()
//     {
//         return $this->est_active ? 'success' : 'secondary';
//     }

//     public function getStatutIconeAttribute()
//     {
//         return $this->est_active ? 'fa-toggle-on' : 'fa-toggle-off';
//     }

  
//     public function getIconeCompleteAttribute()
//     {
//         return $this->icon ?? 'fa-building';
//     }

//     public function getLogoUrlAttribute()
//     {
//         if ($this->logo_path) {
//             return asset('storage/' . $this->logo_path);
//         }

 
//         return match ($this->code) {
//             'nova' => asset('assets/img/nova/logo.png'),
//             'house' => asset('assets/img/house/logo.png'),
//             'patrimoine' => asset('assets/img/patrimoine/logo.png'), // 🏛️ NOUVEAU !
//             'patrimoine_immobilier' => asset('assets/img/patrimoine/logo.png'),
//             default => asset('assets/img/default-logo.png')
//         };
//     }

//     public function getCouleurStyleAttribute()
//     {
//         return "background-color: {$this->couleur}; color: white;";
//     }

//     public function getCouleurContrastAttribute(): string
//     {
//         if (!$this->couleur) {
//             return '#000000';
//         }

//         try {
//             $color = new Color($this->couleur);
//             $r = $color->getRed();
//             $g = $color->getGreen();
//             $b = $color->getBlue();
//            $luminance = (0.2126 * $r + 0.7152 * $g + 0.0722 * $b) / 255;

//             return $luminance > 0.5 ? '#000000' : '#FFFFFF';
//         } catch (\Exception $e) {
//             return '#000000';
//         }
//     }

//     public function getColorPaletteAttribute(): array
//     {
//         $baseColor = $this->couleur ?? '#3B82F6';

//         return [
//             'primary' => $baseColor,
//             'light' => $this->lightenColor($baseColor, 30),
//             'dark' => $this->darkenColor($baseColor, 30),
//             'muted' => $this->desaturateColor($baseColor, 50),
//         ];
//     }

//     protected function lightenColor(string $color, int $percent): string
//     {
       
//         return $color; 
//     }

    
//     public function setCodeAttribute($value)
//     {
      
//         if ($value) {
//             $this->attributes['code'] = Str::slug($value);
//         }
//         // Sinon, on utilise le nom (sera géré par le boot() si nom existe)
//         elseif ($this->nom && !$this->code) {
//             $this->attributes['code'] = Str::slug($this->nom);
//         }
//     }

   
//     public function setCouleurAttribute($value)
//     {
//         if (!empty($value) && !str_starts_with($value, '#')) {
//             $value = '#' . $value;
//         }
//         $this->attributes['couleur'] = $value;
//     }

  
//     public function setIconAttribute($value)
//     {
//         if (!empty($value) && !str_starts_with($value, 'fa-')) {
//             $value = 'fa-' . $value;
//         }
//         $this->attributes['icon'] = $value;
//     }

 
//     public function hasDocuments(): bool
//     {
//         return $this->documents()->exists();
//     }

//     public function countDocuments(): int
//     {
//         return $this->documents()->count();
//     }
//     public function getStats(): array
//     {
//         $documents = $this->documents();
//         $total = $documents->count();
//         $totalMontant = $documents->sum('montant_ttc');

//         return [
//             'total_documents' => $total,
//             'total_montant' => $totalMontant,
//             'moyenne_montant' => $total > 0 ? round($totalMontant / $total, 2) : 0,
//             'par_type' => $this->getDocumentsByType(),
//             'par_activite' => $this->getDocumentsByActivity(),
//             'par_mois' => $this->getMonthlyStats(12),
//             'top_adresses' => $this->getTopAdresses(5),
//             'evolution' => $this->getEvolutionStats(),
//         ];
//     }

  
//     protected function getDocumentsByType(): array
//     {
//         return $this->documents()
//             ->selectRaw('type, COUNT(*) as count, SUM(montant_ttc) as total')
//             ->groupBy('type')
//             ->get()
//             ->mapWithKeys(function ($item) {
//                 return [
//                     $item->type => [
//                         'count' => $item->count,
//                         'total' => $item->total,
//                         'percentage' => 0 // À calculer
//                     ]
//                 ];
//             })
//             ->toArray();
//     }

//     public function getMonthlyStats(int $months = 12): array
//     {
//         return $this->documents()
//             ->selectRaw('
//             YEAR(created_at) as year,
//             MONTH(created_at) as month,
//             COUNT(*) as count,
//             SUM(montant_ttc) as total
//         ')
//             ->where('created_at', '>=', now()->subMonths($months))
//             ->groupBy('year', 'month')
//             ->orderBy('year', 'desc')
//             ->orderBy('month', 'desc')
//             ->get()
//             ->map(function ($item) {
//                 return [
//                     'period' => "{$item->month}/{$item->year}",
//                     'count' => $item->count,
//                     'total' => $item->total,
//                 ];
//             })
//             ->values()
//             ->toArray();
//     }
 
//     public function activate(): bool
//     {
//         $this->est_active = true;
//         return $this->save();
//     }

   
//     public function deactivate(): bool
//     {
//         $this->est_active = false;
//         return $this->save();
//     }

 
//     public function toggleStatus(): bool
//     {
//         if ($this->est_active && self::where('est_active', true)->count() <= 1) {
//             // Ne rien faire, c'est la dernière active
//             return false;
//         }

//         return $this->update([
//             'est_active' => !$this->est_active
//         ]);
//     }


//     public function isActive(): bool
//     {
//         return $this->est_active === true;
//     }

 
//     public function canBeDeleted(): bool
//     {
//         return !$this->hasDocuments();
//     }


//     public static function findByCode(string $code): ?self
//     {
//         return self::where('code', $code)->first();
//     }

  
//     public static function findByCodeOrFail(string $code): self
//     {
//         return self::where('code', $code)->firstOrFail();
//     }

//     public static function getActiveList(): array
//     {
//         return self::active()
//             ->orderBy('nom')
//             ->get()
//             ->mapWithKeys(function ($societe) {
//                 return [$societe->code => $societe->nom_formate];
//             })
//             ->toArray();
//     }

//     public function toArray(): array
//     {
//         return array_merge(parent::toArray(), [
//             'nom_formate' => $this->nom_formate,
//             'adresse_complete' => $this->adresse_complete,
//             'statut_formate' => $this->statut_formate,
//             'statut_couleur' => $this->statut_couleur,
//             'statut_icone' => $this->statut_icone,
//             'icon_complete' => $this->icon_complete,
//             'logo_url' => $this->logo_url,
//             'couleur_style' => $this->couleur_style,
//             'couleur_contrast' => $this->couleur_contrast,
//             'has_documents' => $this->hasDocuments(),
//             'documents_count' => $this->countDocuments(),
//             'created_by' => $this->user ? $this->user->name : 'Inconnu',
//             'created_at_formatted' => $this->created_at->format('d/m/Y H:i'),
//         ]);
//     }

//     public static function forSelect(): array
//     {
//         return self::active()
//             ->orderBy('nom')
//             ->get()
//             ->mapWithKeys(function ($societe) {
//                 return [
//                     $societe->code => "{$societe->nom} ({$societe->code})"
//                 ];
//             })
//             ->toArray();
//     }

   
//     public static function withColors(): array
//     {
//         return self::active()
//             ->orderBy('nom')
//             ->get()
//             ->map(function ($societe) {
//                 return [
//                     'code' => $societe->code,
//                     'nom' => $societe->nom,
//                     'couleur' => $societe->couleur,
//                     'icon' => $societe->icon,
//                     'logo_url' => $societe->logo_url,
//                 ];
//             })
//             ->toArray();
//     }


//     public function uploadLogo($file): bool
//     {
      
//         $path = $file->store('logos/societes', 'public');
//         $this->logo_path = $path;

//         return $this->save();
//     }

   
//     public function deleteLogo(): bool
//     {
//         if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
//             Storage::disk('public')->delete($this->logo_path);
//             $this->logo_path = null;
//             return $this->save();
//         }

//         return false;
//     }

//     public function hasLogo(): bool
//     {
//         return !empty($this->logo_path) && Storage::disk('public')->exists($this->logo_path);
//     }

//     public function syncActivites(array $activiteIds): void
//     {
//         $this->activites()->sync($activiteIds);
//     }

   
//     public function hasActivite($activiteId): bool
//     {
//         return $this->activites()->where('activite_id', $activiteId)->exists();
//     }
// }




namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Color;


class Societe extends Model
{
    use HasFactory, SoftDeletes;

    // =========================================================================
    // CHAMPS FILLABLE (AVEC LES NOUVEAUX CHAMPS)
    // =========================================================================
    protected $fillable = [
        'nom',
        'display_name',           // ✅ NOUVEAU : nom d'affichage personnalisable
        'code',
        'template_pdf_folder',    // ✅ NOUVEAU : dossier pour les templates PDF
        'metadata',                // ✅ NOUVEAU : stockage JSON pour données supplémentaires
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
        'metadata' => 'array',      // ✅ Pour stocker des données JSON
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($societe) {
            if (empty($societe->code) && !empty($societe->nom)) {
                $societe->code = Str::slug($societe->nom);
            }

            if (empty($societe->user_id) && auth()->check()) {
                $societe->user_id = auth()->id();
            }
            
            // ✅ Définir template_pdf_folder par défaut
            if (empty($societe->template_pdf_folder)) {
                $societe->template_pdf_folder = $societe->code;
            }
        });

        static::updating(function ($societe) {
            if ($societe->isDirty('nom') && empty($societe->code)) {
                $societe->code = Str::slug($societe->nom);
            }
        });
    }

    // =========================================================================
    // RELATIONS
    // =========================================================================
    public function documents()
    {
        return $this->hasMany(Document::class, 'society', 'code');
    }

    public function activites()
    {
        return $this->belongsToMany(Activite::class, 'activite_societe');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // =========================================================================
    // SCOPES
    // =========================================================================
    public function scopeActive($query)
    {
        return $query->where('est_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('est_active', false);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nom', 'LIKE', "%{$search}%")
                ->orWhere('display_name', 'LIKE', "%{$search}%")
                ->orWhere('code', 'LIKE', "%{$search}%")
                ->orWhere('ville', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    public function scopeByVille($query, $ville)
    {
        return $query->where('ville', $ville);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // =========================================================================
    // ACCESSORS & MUTATORS - VERSION 100% DYNAMIQUE
    // =========================================================================

    /**
     * ✅ NOM FORMATÉ - PRIORITÉ À LA BDD
     */
    public function getNomFormateAttribute()
    {
        // 1️⃣ Si display_name est défini en BDD, on l'utilise
        if (!empty($this->display_name)) {
            return $this->display_name;
        }
        
        // 2️⃣ Sinon, on utilise le nom standard
        if (!empty($this->nom)) {
            return $this->nom;
        }
        
        // 3️⃣ Fallback sur le code formaté
        return ucfirst(str_replace('_', ' ', $this->code));
    }

    /**
     * ✅ DOSSIER TEMPLATE PDF
     */
    public function getPdfFolderAttribute(): string
    {
        return $this->template_pdf_folder ?? $this->code ?? 'default';
    }

    /**
     * ✅ ADRESSE COMPLÈTE
     */
    public function getAdresseCompleteAttribute()
    {
        $parts = [];
        if ($this->adresse) $parts[] = $this->adresse;
        if ($this->code_postal) $parts[] = $this->code_postal;
        if ($this->ville) $parts[] = $this->ville;

        return implode(', ', $parts);
    }

    /**
     * ✅ STATUT FORMATÉ
     */
    public function getStatutFormateAttribute()
    {
        return $this->est_active ? 'Actif' : 'Inactif';
    }

    public function getStatutCouleurAttribute()
    {
        return $this->est_active ? 'success' : 'secondary';
    }

    public function getStatutIconeAttribute()
    {
        return $this->est_active ? 'fa-toggle-on' : 'fa-toggle-off';
    }

    /**
     * ✅ ICÔNE COMPLÈTE
     */
    public function getIconeCompleteAttribute()
    {
        return $this->icon ?? 'fa-building';
    }

    /**
     * ✅ URL DU LOGO - DYNAMIQUE
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
            return asset('storage/' . $this->logo_path);
        }

        // Logo par défaut basé sur le dossier template
        $defaultLogo = "assets/img/{$this->pdf_folder}/logo.png";
        if (file_exists(public_path($defaultLogo))) {
            return asset($defaultLogo);
        }

        return asset('assets/img/default-logo.png');
    }

    /**
     * ✅ STYLE CSS DE LA COULEUR
     */
    public function getCouleurStyleAttribute()
    {
        return "background-color: {$this->couleur}; color: white;";
    }

    /**
     * ✅ COULEUR CONTRASTÉE
     *//**
 * Accessor pour le texte de la couleur contrastée
 */
public function getCouleurContrastAttribute(): string
{
    if (!$this->couleur) {
        return '#000000';
    }

    // Fonction interne pour calculer la luminance
    $getLuminance = function($hexColor) {
        // Nettoyer et convertir
        $hex = ltrim($hexColor, '#');
        
        if (strlen($hex) == 3) {
            $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        return (0.2126 * $r + 0.7152 * $g + 0.0722 * $b) / 255;
    };

    $luminance = $getLuminance($this->couleur);
    
    return $luminance > 0.5 ? '#000000' : '#FFFFFF';
}
    /**
     * ✅ MÉTADONNÉES - Gestionnaire
     */
    public function getMeta(string $key, $default = null)
    {
        return $this->metadata[$key] ?? $default;
    }

    public function setMeta(string $key, $value): self
    {
        $metadata = $this->metadata ?? [];
        $metadata[$key] = $value;
        $this->metadata = $metadata;
        return $this;
    }

    // =========================================================================
    // MUTATORS
    // =========================================================================
    public function setCodeAttribute($value)
    {
        if ($value) {
            $this->attributes['code'] = Str::slug($value);
        } elseif ($this->nom && !$this->code) {
            $this->attributes['code'] = Str::slug($this->nom);
        }
    }

    public function setCouleurAttribute($value)
    {
        if (!empty($value) && !str_starts_with($value, '#')) {
            $value = '#' . $value;
        }
        $this->attributes['couleur'] = $value;
    }

    public function setIconAttribute($value)
    {
        if (!empty($value) && !str_starts_with($value, 'fa-')) {
            $value = 'fa-' . $value;
        }
        $this->attributes['icon'] = $value;
    }

    // =========================================================================
    // MÉTHODES STATISTIQUES
    // =========================================================================
    public function getDocumentsByActivity(): array
    {
        return $this->documents()
            ->select('activity', DB::raw('COUNT(*) as count'), DB::raw('SUM(montant_ttc) as total'))
            ->whereNotNull('activity')
            ->groupBy('activity')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->activity => [
                        'count' => $item->count,
                        'total' => $item->total ?? 0,
                        'percentage' => 0
                    ]
                ];
            })
            ->toArray();
    }

    public function getTopAdresses(int $limit = 5): array
    {
        return $this->documents()
            ->whereNotNull('adresse_travaux')
            ->where('adresse_travaux', '!=', '')
            ->select('adresse_travaux', DB::raw('COUNT(*) as count'))
            ->groupBy('adresse_travaux')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->adresse_travaux => [
                        'count' => $item->count,
                        'adresse' => $item->adresse_travaux
                    ]
                ];
            })
            ->toArray();
    }

    public function getEvolutionStats(int $months = 12): array
    {
        return $this->documents()
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as period'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(montant_ttc) as total')
            )
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy('period')
            ->orderBy('period', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'period' => $item->period,
                    'count' => (int) $item->count,
                    'total' => (float) ($item->total ?? 0),
                ];
            })
            ->toArray();
    }

    public function getLastMonthStats(): array
    {
        $lastMonth = now()->subMonth();
        
        $documents = $this->documents()
            ->whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month);
        
        $total = $documents->count();
        $totalMontant = $documents->sum('montant_ttc');
        
        return [
            'month' => $lastMonth->translatedFormat('F Y'),
            'year' => $lastMonth->year,
            'month_num' => $lastMonth->month,
            'total_documents' => $total,
            'total_montant' => $totalMontant,
            'moyenne_montant' => $total > 0 ? round($totalMontant / $total, 2) : 0,
            'par_type' => $documents->select('type', DB::raw('COUNT(*) as count'))
                ->groupBy('type')
                ->pluck('count', 'type')
                ->toArray(),
        ];
    }

    public function calculatePercentages(array $stats): array
    {
        $total = $stats['total_documents'] ?? 0;
        
        if ($total > 0 && isset($stats['par_type'])) {
            foreach ($stats['par_type'] as $type => &$data) {
                if (is_array($data)) {
                    $data['percentage'] = round(($data['count'] / $total) * 100, 1);
                }
            }
        }
        
        if ($total > 0 && isset($stats['par_activite'])) {
            foreach ($stats['par_activite'] as $activite => &$data) {
                if (is_array($data)) {
                    $data['percentage'] = round(($data['count'] / $total) * 100, 1);
                }
            }
        }
        
        return $stats;
    }

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

    public function invalidateStatsCache(): void
    {
        Cache::forget("societe_stats_{$this->id}");
        Cache::forget("societe_evolution_{$this->id}");
    }

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
                        'percentage' => 0
                    ]
                ];
            })
            ->toArray();
    }

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

    // =========================================================================
    // MÉTHODES DE GESTION
    // =========================================================================
    public function hasDocuments(): bool
    {
        return $this->documents()->exists();
    }

    public function countDocuments(): int
    {
        return $this->documents()->count();
    }

    public function activate(): bool
    {
        $this->est_active = true;
        return $this->save();
    }

    public function deactivate(): bool
    {
        $this->est_active = false;
        return $this->save();
    }

    public function toggleStatus(): bool
    {
        if ($this->est_active && self::where('est_active', true)->count() <= 1) {
            return false;
        }

        return $this->update(['est_active' => !$this->est_active]);
    }

    public function isActive(): bool
    {
        return $this->est_active === true;
    }

    public function canBeDeleted(): bool
    {
        return !$this->hasDocuments();
    }

    public static function findByCode(string $code): ?self
    {
        return self::where('code', $code)->first();
    }

    public static function findByCodeOrFail(string $code): self
    {
        return self::where('code', $code)->firstOrFail();
    }

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
            'pdf_folder' => $this->pdf_folder,
            'has_documents' => $this->hasDocuments(),
            'documents_count' => $this->countDocuments(),
            'created_by' => $this->user ? $this->user->name : 'Inconnu',
            'created_at_formatted' => $this->created_at->format('d/m/Y H:i'),
        ]);
    }

    public static function forSelect(): array
    {
        return self::active()
            ->orderBy('nom')
            ->get()
            ->mapWithKeys(function ($societe) {
                return [
                    $societe->code => "{$societe->nom_formate} ({$societe->code})"
                ];
            })
            ->toArray();
    }

    public static function withColors(): array
    {
        return self::active()
            ->orderBy('nom')
            ->get()
            ->map(function ($societe) {
                return [
                    'code' => $societe->code,
                    'nom' => $societe->nom_formate,
                    'couleur' => $societe->couleur,
                    'icon' => $societe->icon,
                    'logo_url' => $societe->logo_url,
                    'pdf_folder' => $societe->pdf_folder,
                ];
            })
            ->toArray();
    }

    public function uploadLogo($file): bool
    {
        $this->deleteLogo();
        $path = $file->store('logos/societes', 'public');
        $this->logo_path = $path;
        return $this->save();
    }

    public function deleteLogo(): bool
    {
        if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
            Storage::disk('public')->delete($this->logo_path);
            $this->logo_path = null;
            return $this->save();
        }
        return false;
    }

    public function hasLogo(): bool
    {
        return !empty($this->logo_path) && Storage::disk('public')->exists($this->logo_path);
    }

    public function syncActivites(array $activiteIds): void
    {
        $this->activites()->sync($activiteIds);
    }

    public function hasActivite($activiteId): bool
    {
        return $this->activites()->where('activite_id', $activiteId)->exists();
    }
}