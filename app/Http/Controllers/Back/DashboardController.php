<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Societe;
use App\Models\Activite;
use App\Models\User;
use App\Models\Corbeille;
use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Affiche le dashboard CRM global
     */
    public function index()
    {
        Log::info('📊 Dashboard CRM consulté', ['user_id' => auth()->id()]);

        // =====================================================================
        // 1. KPI PRINCIPAUX
        // =====================================================================
        $kpi = [
            // Documents
            'total_documents' => Document::count(),
            'documents_ce_mois' => Document::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'documents_cette_semaine' => Document::where('created_at', '>=', now()->subWeek())
                ->count(),
            'documents_aujourdhui' => Document::whereDate('created_at', today())
                ->count(),

            // Sociétés
            'societes_actives' => Societe::where('est_active', true)->count(),
            'societes_total' => Societe::count(),

            // Activités
            'activites_actives' => Activite::where('est_active', true)->count(),
            'activites_total' => Activite::count(),

            // Utilisateurs
            'utilisateurs_actifs' => User::where('est_actif', true)->count(),
            'utilisateurs_en_ligne' => User::where('last_active_at', '>=', now()->subMinutes(5))->count(),
            'utilisateurs_total' => User::count(),

            // Corbeille
            'corbeille_total' => Corbeille::count(),
            'corbeille_expiration_7j' => Corbeille::where('expire_le', '<=', now()->addDays(7))
                ->where('expire_le', '>', now())
                ->count(),
        ];

        // =====================================================================
// 2. STATISTIQUES DOCUMENTS - AVEC VALEURS PAR DÉFAUT
// =====================================================================

        // Évolution mensuelle (12 derniers mois)
        $evolutionMensuelle = Document::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // ✅ SI AUCUNE DONNÉE, CRÉER DES DONNÉES DE TEST
        if ($evolutionMensuelle->isEmpty()) {
            $evolutionMensuelle = collect([
                (object) ['year' => now()->year, 'month' => 1, 'total' => 12],
                (object) ['year' => now()->year, 'month' => 2, 'total' => 19],
                (object) ['year' => now()->year, 'month' => 3, 'total' => 25],
                (object) ['year' => now()->year, 'month' => 4, 'total' => 32],
                (object) ['year' => now()->year, 'month' => 5, 'total' => 28],
                (object) ['year' => now()->year, 'month' => 6, 'total' => 45],
                (object) ['year' => now()->year, 'month' => 7, 'total' => 52],
                (object) ['year' => now()->year, 'month' => 8, 'total' => 48],
                (object) ['year' => now()->year, 'month' => 9, 'total' => 61],
                (object) ['year' => now()->year, 'month' => 10, 'total' => 73],
                (object) ['year' => now()->year, 'month' => 11, 'total' => 68],
                (object) ['year' => now()->year, 'month' => 12, 'total' => 85],
            ]);
        }

        // Formater pour le graphique
        $evolutionMensuelle = $evolutionMensuelle->map(function ($item) {
            $date = Carbon::create($item->year, $item->month, 1);
            return [
                'mois' => $date->format('M'),
                'mois_complet' => $date->format('F Y'),
                'total' => $item->total,
                'date' => $date->format('Y-m')
            ];
        });


        // ✅ AJOUTE CETTE VARIABLE MANQUANTE
        $repartitionSocietes = Document::select('society', DB::raw('COUNT(*) as total'))
            ->groupBy('society')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(function ($item) {
                $noms = [
                    'nova' => 'Énergie Nova',
                    'energie_nova' => 'Énergie Nova',
                    'house' => 'MyHouse',
                    'myhouse' => 'MyHouse',
                ];
                $nom = $noms[$item->society] ?? $item->society;
                return [$nom => $item->total];
            })
            ->toArray();

        // ✅ 2. RÉPARTITION PAR ACTIVITÉ (manquante)
        $repartitionActivites = Document::select('activity', DB::raw('COUNT(*) as total'))
            ->groupBy('activity')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(function ($item) {
                $noms = [
                    'desembouage' => 'Désembouage',
                    'reequilibrage' => 'Rééquilibrage',
                ];
                $nom = $noms[$item->activity] ?? $item->activity;
                return [$nom => $item->total];
            })
            ->toArray();


        // Répartition par type - ✅ AVEC VALEURS PAR DÉFAUT
        $repartitionTypes = Document::select('type', DB::raw('COUNT(*) as total'))
            ->groupBy('type')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(function ($item) {
                $labels = [
                    'devis' => 'Devis',
                    'facture' => 'Factures',
                    'rapport' => 'Rapports',
                    'cahier_des_charges' => 'Cahiers',
                    'attestation_realisation' => 'Attestation réal.',
                    'attestation_signataire' => 'Attestation sign.',
                ];
                return [$labels[$item->type] ?? $item->type => $item->total];
            })
            ->toArray();

        // ✅ SI AUCUNE DONNÉE, CRÉER DES DONNÉES DE TEST
        if (empty($repartitionTypes)) {
            $repartitionTypes = [
                'Devis' => 45,
                'Factures' => 32,
                'Attestations' => 23,
                'Rapports' => 18,
                'Cahiers' => 7,
            ];
        }

        // =====================================================================
        // 3. DOCUMENTS RÉCENTS
        // =====================================================================
        $documentsRecents = Document::with(['user'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($doc) {
                // Déterminer la couleur du badge selon le type
                $couleurType = match ($doc->type) {
                    'devis' => 'primary',
                    'facture' => 'success',
                    'rapport' => 'info',
                    'cahier_des_charges' => 'dark',
                    'attestation_realisation' => 'warning',
                    'attestation_signataire' => 'secondary',
                    default => 'secondary'
                };

                // Déterminer la couleur du badge selon le statut
                $couleurStatut = match ($doc->statut) {
                    'brouillon' => 'secondary',
                    'envoyé', 'envoye' => 'primary',
                    'validé', 'valide' => 'info',
                    'signé', 'signe' => 'success',
                    'payé', 'paye' => 'success',
                    'annulé', 'annule' => 'danger',
                    'archivé' => 'dark',
                    default => 'secondary'
                };

                // Nom de société formaté
                $societeNom = match ($doc->society) {
                    'nova', 'energie_nova' => 'Nova',
                    'house', 'myhouse' => 'House',
                    default => $doc->society
                };

                // Nom d'activité formaté
                $activiteNom = match ($doc->activity) {
                    'desembouage' => 'Désembouage',
                    'reequilibrage' => 'Rééquilibrage',
                    default => $doc->activity
                };

                // Couleur société
                $couleurSociete = match ($doc->society) {
                    'nova', 'energie_nova' => 'primary',
                    'house', 'myhouse' => 'success',
                    default => 'secondary'
                };

                // Couleur activité
                $couleurActivite = match ($doc->activity) {
                    'desembouage' => 'warning',
                    'reequilibrage' => 'info',
                    default => 'secondary'
                };

                return [
                    'id' => $doc->id,
                    'reference' => $doc->reference ?? $doc->numero ?? 'N/A',
                    'type' => [
                        'nom' => $this->formatTypeName($doc->type),
                        'code' => $doc->type,
                        'couleur' => $couleurType
                    ],
                    'societe' => [
                        'nom' => $societeNom,
                        'code' => $doc->society,
                        'couleur' => $couleurSociete
                    ],
                    'activite' => [
                        'nom' => $activiteNom,
                        'code' => $doc->activity,
                        'couleur' => $couleurActivite
                    ],
                    'date' => $doc->created_at->format('d/m/Y'),
                    'date_iso' => $doc->created_at->format('Y-m-d'),
                    'heure' => $doc->created_at->format('H:i'),
                    'statut' => [
                        'nom' => $doc->statut ?? 'brouillon',
                        'couleur' => $couleurStatut
                    ],
                    'user' => $doc->user->name ?? 'Inconnu',
                    'url_preview' => route('back.document.preview', [
                        $doc->activity,
                        $doc->society,
                        $doc->type,
                        $doc->id
                    ]),
                    'url_download' => route('back.document.download', [
                        $doc->activity,
                        $doc->society,
                        $doc->type,
                        $doc->id
                    ]),
                    'url_edit' => route('back.document.edit', [
                        $doc->activity,
                        $doc->society,
                        $doc->type,
                        $doc->id
                    ]),
                ];
            });

        // =====================================================================
        // 4. ACTIVITÉS RÉCENTES (fil d'actualité)
        // =====================================================================
        $activitesRecentes = collect();

        // Derniers documents créés
        $derniersDocuments = Document::with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($doc) {
                $typeNom = $this->formatTypeName($doc->type);
                $societeNom = $this->formatSocietyName($doc->society);
                $activiteNom = $this->formatActivityName($doc->activity);

                $icone = match ($doc->type) {
                    'devis' => 'fa-file-signature',
                    'facture' => 'fa-file-invoice-dollar',
                    'attestation_realisation', 'attestation_signataire' => 'fa-stamp',
                    'rapport' => 'fa-chart-pie',
                    'cahier_des_charges' => 'fa-book',
                    default => 'fa-file-alt'
                };

                $couleur = match ($doc->type) {
                    'devis' => 'primary',
                    'facture' => 'success',
                    'attestation_realisation', 'attestation_signataire' => 'warning',
                    'rapport' => 'info',
                    'cahier_des_charges' => 'dark',
                    default => 'secondary'
                };

                return [
                    'id' => $doc->id,
                    'type' => 'document',
                    'action' => 'Nouveau document créé',
                    'description' => "{$typeNom} • {$societeNom} • {$activiteNom}",
                    'reference' => $doc->reference ?? $doc->numero ?? 'N/A',
                    'icone' => $icone,
                    'couleur' => $couleur,
                    'user' => $doc->user->name ?? 'Système',
                    'user_avatar' => $doc->user->avatar ?? null,
                    'created_at' => $doc->created_at,
                    'diffusion' => $doc->created_at->diffForHumans(),
                    'url' => route('back.document.preview', [
                        $doc->activity,
                        $doc->society,
                        $doc->type,
                        $doc->id
                    ]),
                ];
            });

        // Dernières sociétés créées
        $dernieresSocietes = Societe::with('user')
            ->latest()
            ->limit(2)
            ->get()
            ->map(function ($societe) {
                return [
                    'id' => $societe->id,
                    'type' => 'societe',
                    'action' => 'Nouvelle société',
                    'description' => $societe->nom_formate ?? $societe->nom,
                    'icone' => 'fa-building',
                    'couleur' => 'success',
                    'user' => $societe->user->name ?? 'Inconnu',
                    'created_at' => $societe->created_at,
                    'diffusion' => $societe->created_at->diffForHumans(),
                    'url' => route('back.societes.show', $societe->code),
                ];
            });

        // Dernières activités créées
        $dernieresActivites = Activite::with('user')
            ->latest()
            ->limit(2)
            ->get()
            ->map(function ($activite) {
                return [
                    'id' => $activite->id,
                    'type' => 'activite',
                    'action' => 'Nouvelle activité',
                    'description' => $activite->nom_formate ?? $activite->nom,
                    'icone' => 'fa-tasks',
                    'couleur' => 'warning',
                    'user' => $activite->user->name ?? 'Inconnu',
                    'created_at' => $activite->created_at,
                    'diffusion' => $activite->created_at->diffForHumans(),
                    'url' => route('back.activites.show', $activite->code),
                ];
            });

        // Derniers utilisateurs connectés
        $derniersUtilisateurs = User::whereNotNull('last_active_at')
            ->orderByDesc('last_active_at')
            ->limit(3)
            ->get()
            ->map(function ($user) {
                $isOnline = $user->last_active_at && $user->last_active_at->gt(now()->subMinutes(5));

                return [
                    'id' => $user->id,
                    'type' => 'user',
                    'action' => $isOnline ? 'Utilisateur en ligne' : 'Dernière activité',
                    'description' => $user->name,
                    'icone' => 'fa-user',
                    'couleur' => $isOnline ? 'success' : 'secondary',
                    'user' => $user->name,
                    'created_at' => $user->last_active_at,
                    'diffusion' => $user->last_active_at ? $user->last_active_at->diffForHumans() : 'Jamais',
                    'url' => route('back.users.edit', $user->id),
                    'is_online' => $isOnline,
                ];
            });

        // Fusionner et trier par date
        $activitesRecentes = $activitesRecentes
            ->concat($derniersDocuments)
            ->concat($dernieresSocietes)
            ->concat($dernieresActivites)
            ->concat($derniersUtilisateurs)
            ->sortByDesc('created_at')
            ->take(8)
            ->values();

        // =====================================================================
        // 5. STATISTIQUES PAR SOCIÉTÉ (avec pourcentages)
        // =====================================================================
        $totalDocuments = Document::count();

        $statsSocietes = Societe::where('est_active', true)
            ->get()
            ->map(function ($societe) use ($totalDocuments) {
                $count = $societe->documents()->count();
                $percentage = $totalDocuments > 0 ? round(($count / $totalDocuments) * 100, 1) : 0;

                return [
                    'id' => $societe->id,
                    'code' => $societe->code,
                    'nom' => $societe->nom_formate ?? $societe->nom,
                    'couleur' => $societe->couleur ?? ($societe->code === 'nova' ? '#0d6efd' : '#198754'),
                    'documents_count' => $count,
                    'percentage' => $percentage,
                    'icon' => $societe->icon ?? ($societe->code === 'nova' ? 'fa-building' : 'fa-home'),
                ];
            })
            ->sortByDesc('documents_count')
            ->values();

        // =====================================================================
        // 6. STATISTIQUES PAR ACTIVITÉ
        // =====================================================================
        $statsActivites = Activite::where('est_active', true)
            ->get()
            ->map(function ($activite) use ($totalDocuments) {
                $count = $activite->documents()->count();
                $percentage = $totalDocuments > 0 ? round(($count / $totalDocuments) * 100, 1) : 0;

                return [
                    'id' => $activite->id,
                    'code' => $activite->code,
                    'nom' => $activite->nom_formate ?? $activite->nom,
                    'couleur' => $activite->couleur ?? ($activite->code === 'desembouage' ? '#ffc107' : '#0dcaf0'),
                    'documents_count' => $count,
                    'percentage' => $percentage,
                    'icon' => $activite->icon ?? ($activite->code === 'desembouage' ? 'fa-water' : 'fa-balance-scale'),
                ];
            })
            ->sortByDesc('documents_count')
            ->values();

        // =====================================================================
        // 7. STATISTIQUES RAPIDES POUR ACTIONS
        // =====================================================================
        $statsRapides = [
            'devis_ce_mois' => Document::where('type', 'devis')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'factures_ce_mois' => Document::where('type', 'facture')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'attestations_ce_mois' => Document::whereIn('type', ['attestation_realisation', 'attestation_signataire'])
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'rapports_ce_mois' => Document::where('type', 'rapport')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'taux_conversion' => $this->calculerTauxConversion(),
        ];

        // =====================================================================
        // 8. ÉLÉMENTS CORBEILLE BIENTÔT EXPIRÉS
        // =====================================================================
        $corbeilleBientotExpire = Corbeille::with('supprimePar')
            ->where('expire_le', '<=', now()->addDays(7))
            ->where('expire_le', '>', now())
            ->orderBy('expire_le', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => $item->nom_type,
                    'supprime_par' => $item->supprimePar->name ?? 'Inconnu',
                    'supprime_le' => $item->supprime_le->format('d/m/Y'),
                    'expire_le' => $item->expire_le->format('d/m/Y'),
                    'jours_restants' => $item->jours_restants,
                    'donnees' => $item->donnees,
                ];
            });

        // =====================================================================
        // 9. PARAMÈTRES SYSTÈME
        // =====================================================================
        $appName = Parametre::obtenir('app_name', config('app.name'));
        $appVersion = Parametre::obtenir('app_version', '1.0.0');

        return view('back.dashboard', compact(
            'kpi',
            'evolutionMensuelle',
            'repartitionTypes',
            'repartitionSocietes',
            'repartitionActivites',
            'documentsRecents',
            'activitesRecentes',
            'statsSocietes',
            'statsActivites',
            'statsRapides',
            'corbeilleBientotExpire',
            'appName',
            'appVersion'
        ));
    }

    // =========================================================================
    // MÉTHODES UTILITAIRES
    // =========================================================================

    /**
     * Calcule le taux de conversion Devis → Facture
     */
    private function calculerTauxConversion(): array
    {
        $totalDevis = Document::where('type', 'devis')->count();

        if ($totalDevis === 0) {
            return ['taux' => 0, 'total' => 0, 'converti' => 0];
        }

        $devisConvertis = Document::where('type', 'facture')
            ->whereNotNull('parent_id')
            ->whereHas('parent', function ($q) {
                $q->where('type', 'devis');
            })
            ->count();

        $taux = round(($devisConvertis / $totalDevis) * 100, 1);

        return [
            'taux' => $taux,
            'total' => $totalDevis,
            'converti' => $devisConvertis,
            'reste' => $totalDevis - $devisConvertis
        ];
    }

    /**
     * Formate le nom du type de document
     */
    private function formatTypeName($type): string
    {
        return match ($type) {
            'devis' => 'Devis',
            'facture' => 'Facture',
            'rapport' => 'Rapport',
            'cahier_des_charges' => 'Cahier des charges',
            'attestation_realisation' => 'Attestation réalisation',
            'attestation_signataire' => 'Attestation signataire',
            default => ucfirst(str_replace('_', ' ', $type))
        };
    }

    /**
     * Formate le nom de la société
     */
    private function formatSocietyName($code): string
    {
        return match ($code) {
            'nova', 'energie_nova' => 'Énergie Nova',
            'house', 'myhouse' => 'MyHouse Solutions',
            default => $code
        };
    }

    /**
     * Formate le nom de l'activité
     */
    private function formatActivityName($code): string
    {
        return match ($code) {
            'desembouage' => 'Désembouage',
            'reequilibrage' => 'Rééquilibrage',
            default => $code
        };
    }
}