<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'society',
        'activity',
        'type',
        'parent_id',

        // Devis
        'reference_devis',
        'date_devis',
        'adresse_travaux',
        'numero_immatriculation',
        'nom_residence',
        'parcelle_1',
        'parcelle_2',
        'parcelle_3',
        'parcelle_4',
        'dates_previsionnelles',
        'nombre_batiments',
        'details_batiments',

        // Montants
        'montant_ht',
        'montant_tva',
        'montant_ttc',
        'prime_cee',
        'reste_a_charge',

        'puissance_chaudiere',
        'nombre_logements',
        'nombre_emetteurs',
        'zone_climatique',
        'volume_circuit',
        'nombre_filtres',
        'wh_cumac',
        'somme',
        'volume_total',
        'date_travaux',
        'date_facture',
        'date_signature',
        
        // Rapport / Liens
        'reference_facture',
        'adresse_travaux_1',
        'boite_postale_1',
        'adresse_travaux_2',
        'linked_devis',
        'linked_facture',

        // PDF
        'file_path',

        // User
        'user_id',
    ];

    protected $casts = [
        'date_devis'     => 'date',
        'date_facture'   => 'date',
        'date_travaux'   => 'date',
        'date_signature' => 'date',

        'montant_ht'     => 'decimal:2',
        'montant_tva'    => 'decimal:2',
        'montant_ttc'    => 'decimal:2',
        'prime_cee'      => 'decimal:2',
        'reste_a_charge' => 'decimal:2',
    ];

    // =========================================================================
    // RELATIONS
    // =========================================================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function devis()
    {
        return $this->belongsTo(Document::class, 'linked_devis', 'reference');
    }

    public function facture()
    {
        return $this->belongsTo(Document::class, 'linked_facture', 'reference');
    }

    public function parent()
    {
        return $this->belongsTo(Document::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Document::class, 'parent_id');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    public function scopeBySociety($query, $society)
    {
        return $query->where('society', $society);
    }

    public function scopeByActivity($query, $activity)
    {
        return $query->where('activity', $activity);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeByYear($query, $year = null)
    {
        $year = $year ?? date('Y');
        return $query->whereYear('created_at', $year);
    }

    public function scopeByMonth($query, $year, $month)
    {
        return $query->whereYear('created_at', $year)
                     ->whereMonth('created_at', $month);
    }

    // =========================================================================
    // ACCESSORS & MUTATORS
    // =========================================================================

    public function setReferenceAttribute($value)
    {
        $this->attributes['reference'] = strtoupper($value);
    }

    public function getActivityNameAttribute(): string
    {
        return match($this->activity) {
            'desembouage' => 'Désembouage',
            'reequilibrage' => 'Rééquilibrage',
            default => ucfirst($this->activity)
        };
    }

    public function getSocietyNameAttribute(): string
    {
        return match($this->society) {
            'nova' => 'Énergie Nova',
            'house' => 'MyHouse Solutions',
            default => ucfirst($this->society)
        };
    }

    public function getTypeNameAttribute(): string
    {
        return match($this->type) {
            'devis' => 'Devis',
            'facture' => 'Facture',
            'attestation_realisation' => 'Attestation de réalisation',
            'attestation_signataire' => 'Attestation signataire',
            'rapport' => 'Rapport',
            'cahier_des_charges' => 'Cahier des charges',
            default => ucfirst($this->type)
        };
    }

    public function getFullReferenceAttribute(): string
    {
        return "{$this->society_name} - {$this->activity_name} - {$this->type_name}";
    }

    // =========================================================================
    // MÉTHODES PDF
    // =========================================================================

    public function hasPdf(): bool
    {
        return $this->file_path
            && Storage::disk('public')->exists(
                str_replace('storage/', '', $this->file_path)
            );
    }

    public function getPdfUrlAttribute(): ?string
    {
        return $this->file_path ? asset($this->file_path) : null;
    }

    public function getPdfFullPathAttribute(): ?string
    {
        return $this->file_path
            ? Storage::disk('public')->path(
                str_replace('storage/', '', $this->file_path)
            )
            : null;
    }

    public function getPdfData(): array
    {
        return $this->only($this->fillable);
    }

    // =========================================================================
    // MÉTHODES STATIQUES - ACTIVITÉS
    // =========================================================================

    /**
     * Récupère les documents par activité
     */
    public static function getByActivity(string $activity): Collection
    {
        return self::where('activity', $activity)->get();
    }

    /**
     * Récupère les statistiques complètes d'une activité
     */
    public static function getActivityStats(string $activity): array
    {
        $total = self::where('activity', $activity)->count();
        
        return [
            'total' => $total,
            'by_society' => [
                'nova' => self::where('activity', $activity)->where('society', 'nova')->count(),
                'house' => self::where('activity', $activity)->where('society', 'house')->count()
            ],
            'by_type' => [
                'devis' => self::where('activity', $activity)->where('type', 'devis')->count(),
                'facture' => self::where('activity', $activity)->where('type', 'facture')->count(),
                'attestation_realisation' => self::where('activity', $activity)->where('type', 'attestation_realisation')->count(),
                'attestation_signataire' => self::where('activity', $activity)->where('type', 'attestation_signataire')->count(),
                'rapport' => self::where('activity', $activity)->where('type', 'rapport')->count(),
                'cahier_des_charges' => self::where('activity', $activity)->where('type', 'cahier_des_charges')->count()
            ],
            'by_month' => self::getMonthlyStatsByActivity($activity),
            'montant_total_ttc' => self::where('activity', $activity)->sum('montant_ttc'),
            'montant_moyen_ttc' => $total > 0 ? self::where('activity', $activity)->avg('montant_ttc') : 0,
            'recent_documents' => self::getRecentDocumentsByActivity($activity, 5)
        ];
    }

    /**
     * Récupère l'évolution mensuelle pour une activité
     */
    public static function getMonthlyStatsByActivity(string $activity): array
    {
        $stats = self::where('activity', $activity)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();
        
        $result = [];
        foreach ($stats as $stat) {
            $key = $stat->year . '-' . str_pad($stat->month, 2, '0', STR_PAD_LEFT);
            $result[$key] = $stat->count;
        }
        
        return $result;
    }

    /**
     * Récupère les documents récents pour une activité
     */
    public static function getRecentDocumentsByActivity(string $activity, int $limit = 10): Collection
    {
        return self::where('activity', $activity)
            ->with(['user', 'parent'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Récupère le top des sociétés pour une activité
     */
    public static function getTopSocietiesByActivity(string $activity, int $limit = 5): array
    {
        return self::where('activity', $activity)
            ->selectRaw('society, COUNT(*) as total')
            ->groupBy('society')
            ->orderByDesc('total')
            ->limit($limit)
            ->get()
            ->mapWithKeys(function ($item) {
                $name = match($item->society) {
                    'nova' => 'Énergie Nova',
                    'house' => 'MyHouse Solutions',
                    default => ucfirst($item->society)
                };
                return [$name => $item->total];
            })
            ->toArray();
    }

    // =========================================================================
    // MÉTHODES STATIQUES - SOCIÉTÉS
    // =========================================================================

    /**
     * Récupère les documents par société
     */
    public static function getBySociety(string $society): Collection
    {
        return self::where('society', $society)->get();
    }

    /**
     * Récupère les statistiques complètes d'une société
     */
    public static function getSocietyStats(string $society): array
    {
        $total = self::where('society', $society)->count();
        
        return [
            'total' => $total,
            'by_activity' => [
                'desembouage' => self::where('society', $society)->where('activity', 'desembouage')->count(),
                'reequilibrage' => self::where('society', $society)->where('activity', 'reequilibrage')->count()
            ],
            'by_type' => [
                'devis' => self::where('society', $society)->where('type', 'devis')->count(),
                'facture' => self::where('society', $society)->where('type', 'facture')->count(),
                'attestation_realisation' => self::where('society', $society)->where('type', 'attestation_realisation')->count(),
                'attestation_signataire' => self::where('society', $society)->where('type', 'attestation_signataire')->count(),
                'rapport' => self::where('society', $society)->where('type', 'rapport')->count(),
                'cahier_des_charges' => self::where('society', $society)->where('type', 'cahier_des_charges')->count()
            ],
            'by_month' => self::getMonthlyStatsBySociety($society),
            'montant_total_ttc' => self::where('society', $society)->sum('montant_ttc'),
            'montant_moyen_ttc' => $total > 0 ? self::where('society', $society)->avg('montant_ttc') : 0,
            'top_clients' => self::getTopClientsBySociety($society),
            'recent_documents' => self::getRecentDocumentsBySociety($society, 5)
        ];
    }

    /**
     * Récupère l'évolution mensuelle pour une société
     */
    public static function getMonthlyStatsBySociety(string $society): array
    {
        $stats = self::where('society', $society)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();
        
        $result = [];
        foreach ($stats as $stat) {
            $key = $stat->year . '-' . str_pad($stat->month, 2, '0', STR_PAD_LEFT);
            $result[$key] = $stat->count;
        }
        
        return $result;
    }

    /**
     * Récupère les documents récents pour une société
     */
    public static function getRecentDocumentsBySociety(string $society, int $limit = 10): Collection
    {
        return self::where('society', $society)
            ->with(['user', 'parent'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Récupère les top activités pour une société
     */
    public static function getTopActivitiesBySociety(string $society, int $limit = 5): array
    {
        return self::where('society', $society)
            ->selectRaw('activity, COUNT(*) as total')
            ->groupBy('activity')
            ->orderByDesc('total')
            ->limit($limit)
            ->get()
            ->mapWithKeys(function ($item) {
                $name = match($item->activity) {
                    'desembouage' => 'Désembouage',
                    'reequilibrage' => 'Rééquilibrage',
                    default => ucfirst($item->activity)
                };
                return [$name => $item->total];
            })
            ->toArray();
    }

    /**
     * Récupère les clients les plus fréquents pour une société
     */
    public static function getTopClientsBySociety(string $society, int $limit = 5): array
    {
        $clients = self::where('society', $society)
            ->whereNotNull('adresse_travaux')
            ->selectRaw('adresse_travaux, COUNT(*) as total')
            ->groupBy('adresse_travaux')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
        
        return $clients->map(function ($client) {
            return [
                'adresse' => $client->adresse_travaux,
                'total_documents' => $client->total
            ];
        })->toArray();
    }

    // =========================================================================
    // MÉTHODES STATIQUES - GÉNÉRALES
    // =========================================================================

    /**
     * Compte les documents par type pour une activité/société
     */
    public static function countByType(string $activity, string $society, string $type): int
    {
        return self::where('activity', $activity)
                   ->where('society', $society)
                   ->where('type', $type)
                   ->count();
    }

    /**
     * Récupère les statistiques globales
     */
    public static function getGlobalStats(): array
    {
        $total = self::count();
        
        return [
            'total_documents' => $total,
            'by_activity' => [
                'desembouage' => self::where('activity', 'desembouage')->count(),
                'reequilibrage' => self::where('activity', 'reequilibrage')->count()
            ],
            'by_society' => [
                'nova' => self::where('society', 'nova')->count(),
                'house' => self::where('society', 'house')->count()
            ],
            'by_type' => [
                'devis' => self::where('type', 'devis')->count(),
                'facture' => self::where('type', 'facture')->count(),
                'attestation_realisation' => self::where('type', 'attestation_realisation')->count(),
                'attestation_signataire' => self::where('type', 'attestation_signataire')->count(),
                'rapport' => self::where('type', 'rapport')->count(),
                'cahier_des_charges' => self::where('type', 'cahier_des_charges')->count()
            ],
            'montant_total_ttc' => self::sum('montant_ttc'),
            'documents_ce_mois' => self::whereMonth('created_at', date('m'))
                                     ->whereYear('created_at', date('Y'))
                                     ->count(),
            'documents_semaine' => self::where('created_at', '>=', now()->subWeek())->count()
        ];
    }

    /**
     * Génère une référence unique pour un document
     */
    public static function generateReference(string $society, string $type): string
    {
        $timestamp = time();
        $random = strtoupper(substr(md5($timestamp), 0, 6));
        
        return strtoupper($society)
            . '-' . strtoupper(substr($type, 0, 3))
            . '-' . date('Ymd')
            . '-' . $random;
    }

    /**
     * Récupère les années disponibles pour le filtrage
     */
    public static function getAvailableYears(): array
    {
        return self::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
    }

    /**
     * Vérifie si une activité existe et a des documents
     */
    public static function activityExists(string $activity): bool
    {
        return self::where('activity', $activity)->exists();
    }

    /**
     * Vérifie si une société existe et a des documents
     */
    public static function societyExists(string $society): bool
    {
        return self::where('society', $society)->exists();
    }

    // =========================================================================
    // MÉTHODES D'INSTANCE
    // =========================================================================

    /**
     * Vérifie si le document peut être supprimé
     */
    public function canBeDeleted(): bool
    {
        // Ne peut pas être supprimé s'il a des enfants
        return $this->children()->count() === 0;
    }

    /**
     * Récupère le chemin hiérarchique du document
     */
    public function getDocumentHierarchy(): array
    {
        $hierarchy = [];
        $current = $this;
        
        while ($current) {
            $hierarchy[] = [
                'id' => $current->id,
                'reference' => $current->reference,
                'type' => $current->type,
                'created_at' => $current->created_at->format('d/m/Y')
            ];
            $current = $current->parent;
        }
        
        return array_reverse($hierarchy);
    }

    /**
     * Formate le montant TTC pour l'affichage
     */
    public function getFormattedMontantTtcAttribute(): string
    {
        return $this->montant_ttc ? number_format($this->montant_ttc, 2, ',', ' ') . ' €' : '0,00 €';
    }

    /**
     * Calcule le reste à charge si non défini
     */
    public function calculateResteACharge(): float
    {
        if ($this->reste_a_charge !== null) {
            return $this->reste_a_charge;
        }
        
        if ($this->montant_ttc && $this->prime_cee) {
            return max(0, $this->montant_ttc - $this->prime_cee);
        }
        
        return $this->montant_ttc ?? 0;
    }
}