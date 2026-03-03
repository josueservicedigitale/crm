<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use App\Services\PdfFillService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Polyfill\Intl\Normalizer\Normalizer;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Societe;        // ← AJOUTE CETTE LIGNE !
use App\Models\Activite;
use Intervention\Image\Color;






class DocumentController extends Controller
{
    protected PdfFillService $pdfFillService;

    public function __construct(PdfFillService $pdfFillService)
    {
        $this->pdfFillService = $pdfFillService;
    }


    public function dashboard($activity, $society)
    {
        // 1️⃣ Normaliser la société (garder le code normalisé pour les requêtes)
        $normalizedSociety = $this->normalizeSociety($society);

        // 2️⃣ Garder le code original pour l'affichage (si besoin)
        $originalSociety = $society;

        // 3️⃣ Récupérer la société depuis la BDD (avec le code normalisé)
        $societe = Societe::where('code', $normalizedSociety)->first();

        // 4️⃣ Si la société n'existe pas en BDD, utiliser des valeurs par défaut
        if (!$societe) {
            Log::warning('⚠️ Société non trouvée en BDD', [
                'original' => $originalSociety,
                'normalized' => $normalizedSociety
            ]);

            // Créer un objet virtuel avec des valeurs par défaut
            $societe = (object) [
                'nom_formate' => $this->getSocietyDisplayName($normalizedSociety, $originalSociety),
                'couleur' => $this->getSocietyColor($normalizedSociety),
                'icon' => $this->getSocietyIcon($normalizedSociety),
            ];
        }

        // 5️⃣ Propriétés pour la vue
        $societyName = $societe->nom_formate ?? $this->getSocietyDisplayName($normalizedSociety, $originalSociety);
        $societyColor = $societe->couleur ?? $this->getSocietyColor($normalizedSociety);
        $societyIcon = $societe->icon ?? $this->getSocietyIcon($normalizedSociety);

        // 6️⃣ Vue générique
        $viewName = "back.dossiers.generic.{$activity}";

        if (!view()->exists($viewName)) {
            abort(500, "Vue générique non trouvée: {$viewName}");
        }

        // 7️⃣ Statistiques (TOUJOURS avec le code normalisé)
        $stats = $this->getDashboardStats($normalizedSociety, $activity);
        $recentDocuments = $this->getRecentDocuments($normalizedSociety, $activity);
        $topClients = $this->getTopClients($normalizedSociety, $activity);

        Log::info('✅ Dashboard avec normalisation', [
            'original' => $originalSociety,
            'normalized' => $normalizedSociety,
            'activity' => $activity,
            'society_name' => $societyName,
            'color' => $societyColor
        ]);

        return view($viewName, compact(
            'activity',
            'society',           // Code original (ex: 'nova', 'house')
            'normalizedSociety', // Code normalisé (ex: 'energie_nova')
            'societyName',
            'societyColor',
            'societyIcon',
            'stats',
            'recentDocuments',
            'topClients'
        ));
    }

    /**
     * Nom d'affichage de la société
     */
    private function getSocietyDisplayName($normalizedCode, $originalCode = null)
    {
        $displayNames = [
            'energie_nova' => 'Énergie Nova',
            'myhouse' => 'MyHouse Solutions',
            'patrimoine' => 'Patrimoine Immobilier',
        ];

        return $displayNames[$normalizedCode] ?? ucfirst($originalCode ?? $normalizedCode);
    }

    /**
     * Couleur de la société
     */
    private function getSocietyColor($normalizedCode)
    {
        $colors = [
            'energie_nova' => '#0d6efd',  // Bleu
            'myhouse' => '#198754',       // Vert
            'patrimoine' => '#0dcaf0',    // Bleu ciel
        ];

        return $colors[$normalizedCode] ?? '#6c757d'; // Gris par défaut
    }

    /**
     * Icône de la société
     */
    private function getSocietyIcon($normalizedCode)
    {
        $icons = [
            'energie_nova' => 'fa-building',
            'myhouse' => 'fa-home',
            'patrimoine' => 'fa-landmark',
        ];

        return $icons[$normalizedCode] ?? 'fa-building';
    }

    /**
     * Statistiques du dashboard
     */
    private function getDashboardStats($society, $activity)
    {
        return [
            'total' => Document::where('society', $society)
                ->where('activity', $activity)
                ->count(),
            'devis' => Document::where('society', $society)
                ->where('activity', $activity)
                ->where('type', 'devis')
                ->count(),
            'factures' => Document::where('society', $society)
                ->where('activity', $activity)
                ->where('type', 'facture')
                ->count(),
            'rapports' => Document::where('society', $society)
                ->where('activity', $activity)
                ->where('type', 'rapport')
                ->count(),
            'cahiers' => Document::where('society', $society)
                ->where('activity', $activity)
                ->where('type', 'cahier_des_charges')
                ->count(),
            'attestations' => Document::where('society', $society)
                ->where('activity', $activity)
                ->whereIn('type', ['attestation_realisation', 'attestation_signataire'])
                ->count(),
            'ce_mois' => Document::where('society', $society)
                ->where('activity', $activity)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'cette_semaine' => Document::where('society', $society)
                ->where('activity', $activity)
                ->where('created_at', '>=', now()->subWeek())
                ->count(),
        ];
    }

    /**
     * Récupère les documents récents
     */
    private function getRecentDocuments($society, $activity, $limit = 5)
    {
        return Document::where('society', $society)
            ->where('activity', $activity)
            ->with('user')
            ->latest()
            ->take($limit)
            ->get();
    }
    /**
     * Top clients par adresse
     */
    private function getTopClients($society, $activity, $limit = 5)
    {
        $topClients = Document::where('society', $society)
            ->where('activity', $activity)
            ->whereNotNull('nom_residence')
            ->where('nom_residence', '!=', '')
            ->selectRaw('nom_residence as client_nom, COUNT(*) as total, SUM(montant_ttc) as total_montant')
            ->groupBy('nom_residence')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();

        if ($topClients->isEmpty()) {
            $topClients = Document::where('society', $society)
                ->where('activity', $activity)
                ->whereNotNull('adresse_travaux')
                ->where('adresse_travaux', '!=', '')
                ->selectRaw('SUBSTRING(adresse_travaux, 1, 50) as client_nom, COUNT(*) as total, SUM(montant_ttc) as total_montant')
                ->groupBy('adresse_travaux')
                ->orderByDesc('total')
                ->limit($limit)
                ->get();
        }

        return $topClients;
    }
    private function getSocietyName($society)
    {
        $names = [
            'energie_nova' => 'Énergie Nova',
            'nova' => 'Énergie Nova',
            'myhouse' => 'MyHouse Solutions',
            'house' => 'MyHouse Solutions',
            'patrimoine' => 'Patrimoine Immobilier',
        ];
        return $names[$society] ?? ucfirst($society);
    }

    // private function normalizeSociety($society)
    // {
    //     $mapping = [
    //         'nova' => 'energie_nova',
    //         'house' => 'myhouse',
    //         'energie_nova' => 'energie_nova',
    //         'myhouse' => 'myhouse',
    //         'patrimoine' => 'patrimoine',
    //         'patrimoine_immobilier' => 'patrimoine',
    //     ];

    //     return $mapping[$society] ?? $society;
    // }


    //     private function normalizeSociety($society)
// {
//     $mapping = [
//         // Énergie Nova
//         'nova' => 'energie_nova',
//         'energie_nova' => 'energie_nova',

    //         // MyHouse
//         'house' => 'myhouse',
//         'myhouse' => 'myhouse',

    //         // Patrimoine
//         'patrimoine' => 'patrimoine',
//         'patrimoine_immobilier' => 'patrimoine',
//     ];

    //     return $mapping[$society] ?? $society;
// }

    private function normalizeSociety($society)
    {
        $mapping = [
            // Énergie Nova
            'nova' => 'energie_nova',
            'energie_nova' => 'energie_nova',

            // MyHouse
            'house' => 'myhouse',
            'myhouse' => 'myhouse',

            // Patrimoine
            'patrimoine' => 'patrimoine',
            'patrimoine_immobilier' => 'patrimoine',
        ];

        return $mapping[$society] ?? $society;
    }


    // public function allDashboards()
    // {
    //     Log::info('🌐 Tous les dashboards consultés', ['user_id' => auth()->id()]);

    //     // Activités disponibles
    //     $activites = [
    //         'desembouage' => [
    //             'nom' => 'Désembouage',
    //             'icon' => 'fa-water',
    //             'color' => 'primary',
    //             'description' => 'Nettoyage et désembouage des circuits de chauffage'
    //         ],
    //         'reequilibrage' => [
    //             'nom' => 'Rééquilibrage',
    //             'icon' => 'fa-balance-scale',
    //             'color' => 'info',
    //             'description' => 'Rééquilibrage des circuits hydrauliques'
    //         ]
    //     ];

    //     // Sociétés disponibles
    //     $societes = [
    //         'nova' => [
    //             'nom' => 'Énergie Nova',
    //             'icon' => 'fa-building',
    //             'color' => 'success',
    //             'description' => 'Spécialiste en solutions énergétiques'
    //         ],
    //         'house' => [
    //             'nom' => 'MyHouse Solutions',
    //             'icon' => 'fa-home',
    //             'color' => 'warning',
    //             'description' => 'Solutions résidentielles innovantes'
    //         ],
    //         'patrimoine' => [
    //             'nom' => 'Patrimoine Immobilier',
    //             'icon' => 'fa-landmark',
    //             'color' => 'info',
    //             'description' => 'Services de gestion patrimoniale'
    //         ]
    //     ];

    //     // Statistiques par activité
    //     $activitesAvecStats = [];
    //     foreach ($activites as $key => $activite) {
    //         $activitesAvecStats[$key] = array_merge($activite, [
    //             'documents_count' => Document::where('activity', $key)->count()
    //         ]);
    //     }

    //     // Statistiques par société
    //     $societesAvecStats = [];
    //     foreach ($societes as $key => $societe) {
    //         $societesAvecStats[$key] = array_merge($societe, [
    //             'documents_count' => Document::where('society', $key)->count()
    //         ]);
    //     }

    //     // Toutes les combinaisons
    //     $combinaisons = [];
    //     foreach ($activitesAvecStats as $activiteCode => $activiteInfo) {
    //         foreach ($societesAvecStats as $societeCode => $societeInfo) {
    //             $combinaisons[] = [
    //                 'activite_code' => $activiteCode,
    //                 'activite_nom' => $activiteInfo['nom'],
    //                 'activite_icon' => $activiteInfo['icon'],
    //                 'activite_color' => $activiteInfo['color'],
    //                 'societe_code' => $societeCode,
    //                 'societe_nom' => $societeInfo['nom'],
    //                 'societe_icon' => $societeInfo['icon'],
    //                 'societe_color' => $societeInfo['color'],
    //                 'documents_count' => Document::where('activity', $activiteCode)
    //                     ->where('society', $societeCode)
    //                     ->count(),
    //                 'devis_count' => Document::where('activity', $activiteCode)
    //                     ->where('society', $societeCode)
    //                     ->where('type', 'devis')
    //                     ->count(),
    //                 'factures_count' => Document::where('activity', $activiteCode)
    //                     ->where('society', $societeCode)
    //                     ->where('type', 'facture')
    //                     ->count(),
    //                 'rapports_count' => Document::where('activity', $activiteCode)
    //                     ->where('society', $societeCode)
    //                     ->where('type', 'rapport')
    //                     ->count(),
    //             ];
    //         }
    //     }

    //     // Statistiques globales
    //     $statsGlobales = [
    //         'total_documents' => Document::count(),
    //         'total_activites' => count($activitesAvecStats),
    //         'total_societes' => count($societesAvecStats),
    //         'total_combinaisons' => count($combinaisons),
    //         'documents_ce_mois' => Document::whereMonth('created_at', now()->month)->count(),
    //         'documents_semaine' => Document::where('created_at', '>=', now()->subWeek())->count(),
    //     ];

    //     return view('back.all-dashboards', compact(
    //         'activites',
    //         'societes',
    //         'activitesAvecStats',
    //         'societesAvecStats',
    //         'combinaisons',
    //         'statsGlobales'
    //     ));
    // }
    // =========================================================================
    // VUES GLOBALES DE DOCUMENTS
    // =========================================================================


    public function allDashboards()
    {
        Log::info('🌐 Tous les dashboards consultés', ['user_id' => auth()->id()]);

        // =====================================================================
        // 1️⃣ ACTIVITÉS DEPUIS LA BASE DE DONNÉES
        // =====================================================================
        $activitesModel = Activite::where('est_active', true)
            ->orderBy('nom')
            ->get();

        $activites = [];
        $activitesAvecStats = [];

        foreach ($activitesModel as $act) {
            // Format pour l'affichage
            $activites[$act->code] = [
                'nom' => $act->nom_formate ?? $act->nom,
                'icon' => $act->icon ?? 'fa-tasks',
                'color' => $this->getBootstrapColor($act->couleur), // Conversion hex → Bootstrap
                'description' => $act->description ?? "Gestion des documents d'activité",
            ];

            // Avec statistiques
            $docCount = Document::where('activity', $act->code)->count();
            $activitesAvecStats[$act->code] = array_merge($activites[$act->code], [
                'documents_count' => $docCount,
                'devis_count' => Document::where('activity', $act->code)->where('type', 'devis')->count(),
                'factures_count' => Document::where('activity', $act->code)->where('type', 'facture')->count(),
            ]);
        }

        // =====================================================================
        // 2️⃣ SOCIÉTÉS DEPUIS LA BASE DE DONNÉES
        // =====================================================================
        $societesModel = Societe::where('est_active', true)
            ->orderBy('nom')
            ->get();

        $societes = [];
        $societesAvecStats = [];

        foreach ($societesModel as $soc) {
            // Format pour l'affichage
            $societes[$soc->code] = [
                'nom' => $soc->nom_formate ?? $soc->nom,
                'icon' => $soc->icon ?? 'fa-building',
                'color' => $this->getBootstrapColor($soc->couleur),
                'description' => $soc->description ?? "Gestion documentaire",
            ];

            // Avec statistiques
            $docCount = Document::where('society', $soc->code)->count();
            $societesAvecStats[$soc->code] = array_merge($societes[$soc->code], [
                'documents_count' => $docCount,
                'devis_count' => Document::where('society', $soc->code)->where('type', 'devis')->count(),
                'factures_count' => Document::where('society', $soc->code)->where('type', 'facture')->count(),
            ]);
        }

        // =====================================================================
        // 3️⃣ TOUTES LES COMBINAISONS ACTIVITÉ × SOCIÉTÉ
        // =====================================================================
        $combinaisons = [];

        foreach ($activitesAvecStats as $activiteCode => $activiteInfo) {
            foreach ($societesAvecStats as $societeCode => $societeInfo) {
                $documentsCount = Document::where('activity', $activiteCode)
                    ->where('society', $societeCode)
                    ->count();

                // N'afficher que si au moins 1 document (optionnel)
                // if ($documentsCount == 0) continue;

                $combinaisons[] = [
                    'activite_code' => $activiteCode,
                    'activite_nom' => $activiteInfo['nom'],
                    'activite_icon' => $activiteInfo['icon'],
                    'activite_color' => $activiteInfo['color'],
                    'societe_code' => $societeCode,
                    'societe_nom' => $societeInfo['nom'],
                    'societe_icon' => $societeInfo['icon'],
                    'societe_color' => $societeInfo['color'],
                    'documents_count' => $documentsCount,
                    'devis_count' => Document::where('activity', $activiteCode)
                        ->where('society', $societeCode)
                        ->where('type', 'devis')
                        ->count(),
                    'factures_count' => Document::where('activity', $activiteCode)
                        ->where('society', $societeCode)
                        ->where('type', 'facture')
                        ->count(),
                    'rapports_count' => Document::where('activity', $activiteCode)
                        ->where('society', $societeCode)
                        ->where('type', 'rapport')
                        ->count(),
                    'url' => route('back.dashboard', [
                        'activity' => $activiteCode,
                        'society' => $societeCode
                    ]),
                ];
            }
        }

        // Trier les combinaisons par nombre de documents (décroissant)
        usort($combinaisons, function ($a, $b) {
            return $b['documents_count'] <=> $a['documents_count'];
        });

        // =====================================================================
        // 4️⃣ STATISTIQUES GLOBALES
        // =====================================================================
        $statsGlobales = [
            'total_documents' => Document::count(),
            'total_activites' => $activitesModel->count(),
            'total_societes' => $societesModel->count(),
            'total_combinaisons' => count($combinaisons),
            'documents_ce_mois' => Document::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'documents_semaine' => Document::where('created_at', '>=', now()->subWeek())->count(),
            'documents_ajourdhui' => Document::whereDate('created_at', today())->count(),
            'top_activite' => $activitesAvecStats ? array_key_first($activitesAvecStats) : null,
            'top_societe' => $societesAvecStats ? array_key_first($societesAvecStats) : null,
        ];

        Log::info('✅ allDashboards dynamique', [
            'activites' => $activitesModel->count(),
            'societes' => $societesModel->count(),
            'combinaisons' => count($combinaisons),
            'total_docs' => $statsGlobales['total_documents']
        ]);

        return view('back.all-dashboards', compact(
            'activites',
            'societes',
            'activitesAvecStats',
            'societesAvecStats',
            'combinaisons',
            'statsGlobales'
        ));
    }

    /**
     * Convertit une couleur hexadécimale en classe Bootstrap
     */
    private function getBootstrapColor($hexColor)
    {
        // Si pas de couleur, retourner une classe par défaut
        if (!$hexColor) {
            return 'primary';
        }

        // Mapper les couleurs hex courantes vers Bootstrap
        $map = [
            '#0d6efd' => 'primary',
            '#198754' => 'success',
            '#0dcaf0' => 'info',
            '#ffc107' => 'warning',
            '#dc3545' => 'danger',
            '#6c757d' => 'secondary',
            '#212529' => 'dark',
        ];

        // Chercher dans le mapping
        foreach ($map as $hex => $class) {
            if (strcasecmp($hexColor, $hex) == 0) {
                return $class;
            }
        }

        // Si non trouvé, retourner primary par défaut
        return 'primary';
    }



    public function tousDocuments(Request $request)
    {
        Log::info('📄 Tous les documents consultés', ['user_id' => auth()->id()]);

        $query = Document::with(['user', 'parent']);

        // Filtres
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('activity')) {
            $query->where('activity', $request->activity);
        }

        if ($request->filled('society')) {
            $query->where('society', $request->society);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'LIKE', "%{$search}%")
                    ->orWhere('nom_residence', 'LIKE', "%{$search}%") // Modifié ici
                    ->orWhere('adresse_travaux', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('date', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('date', '<=', $request->date_fin);
        }

        $documents = $query->latest()->paginate(25)->withQueryString();

        // Statistiques pour les filtres
        $stats = [
            'total' => Document::count(),
            'devis' => Document::where('type', 'devis')->count(),
            'factures' => Document::where('type', 'facture')->count(),
            'rapports' => Document::where('type', 'rapport')->count(),
        ];

        return view('back.documents.tous', compact('documents', 'stats'));
    }

    public function searchGlobal(Request $request)
    {
        $request->validate([
            'search' => 'required|string|min:2'
        ]);

        $search = $request->search;

        $documents = Document::with(['user', 'parent'])
            ->where(function ($query) use ($search) {
                $query->where('reference', 'LIKE', "%{$search}%")
                    ->orWhere('nom_residence', 'LIKE', "%{$search}%") // Modifié ici
                    ->orWhere('adresse_travaux', 'LIKE', "%{$search}%")
                    ->orWhere('ville', 'LIKE', "%{$search}%")
                    ->orWhere('code_postal', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('back.documents.search', compact('documents', 'search'));
    }

    // public function creationRapide()
    // {
    //     Log::info('⚡ Page création rapide consultée', ['user_id' => auth()->id()]);

    //     $activites = [
    //         'desembouage' => 'Désembouage',
    //         'reequilibrage' => 'Rééquilibrage'
    //     ];

    //     $societes = [
    //         'nova' => 'Énergie Nova',
    //         'house' => 'MyHouse Solutions',
    //         'patrimoine' => 'Patrimoine Immobilier'

    //     ];

    //     $types = [
    //         'devis' => 'Devis',
    //         'facture' => 'Facture',
    //         'rapport' => 'Rapport',
    //         'cahier_des_charges' => 'Cahier des charges',
    //         'attestation_realisation' => 'Attestation de réalisation',
    //         'attestation_signataire' => 'Attestation signataire'
    //     ];

    //     return view('back.documents.creation-rapide', compact('activites', 'societes', 'types'));
    // }



    public function creationRapide()
    {
        Log::info('⚡ Page création rapide consultée', ['user_id' => auth()->id()]);

        // =====================================================================
//ajout
        // =====================================================================
        $activitesModel = Activite::where('est_active', true)
            ->orderBy('nom')
            ->get();

        $activites = [];
        foreach ($activitesModel as $act) {
            $activites[$act->code] = $act->nom_formate ?? $act->nom;
        }

        // =====================================================================
//ajout
        // =====================================================================
        $societesModel = Societe::where('est_active', true)
            ->orderBy('nom')
            ->get();

        $societes = [];
        foreach ($societesModel as $soc) {
            $societes[$soc->code] = $soc->nom_formate ?? $soc->nom;
        }

        // =====================================================================
        //ajout
        // =====================================================================
        // Option A: Garder en dur car les types sont fixes
        $types = [
            'devis' => 'Devis',
            'facture' => 'Facture',
            'rapport' => 'Rapport',
            'cahier_des_charges' => 'Cahier des charges',
            'attestation_realisation' => 'Attestation de réalisation',
            'attestation_signataire' => 'Attestation signataire'
        ];
        $typeIcons = [
            'devis' => 'fa-file-signature',
            'facture' => 'fa-file-invoice-dollar',
            'rapport' => 'fa-chart-pie',
            'cahier_des_charges' => 'fa-book',
            'attestation_realisation' => 'fa-stamp',
            'attestation_signataire' => 'fa-stamp',
        ];
        // Option B: Si tu veux encore plus de flexibilité, depuis une table
        // $types = TypeDocument::where('est_actif', true)->pluck('nom', 'code')->toArray();

        Log::info('✅ Création rapide dynamique', [
            'activites_trouvees' => count($activites),
            'societes_trouvees' => count($societes),
            'types_disponibles' => count($types)
        ]);

        return view('back.documents.creation-rapide', compact('activites', 'societes', 'types', 'typeIcons'));
    }



    public function chooseAction($activity, $society, $type)
    {
        return view('back.dossiers.choose_action', compact('activity', 'society', 'type'));
    }
    public function selectDevis(Request $request, $activity, $society, $type)
    {
        abort_if(!in_array($type, [
            'facture',
            'attestation_realisation',
            'attestation_signataire',
            'cahier_des_charges'
        ]), 404);

        // NORMALISER
        $normalizedSociety = $this->normalizeSociety($society);

        // Base query
        $query = Document::where([
            'activity' => $activity,
            'society' => $normalizedSociety,
            'type' => 'devis',
        ]);

        // 🔍 AJOUT DE LA RECHERCHE
        if ($request->filled('search')) {
            $query->where('reference_devis', 'LIKE', '%' . $request->search . '%');
        }

        $devisList = $query->latest()->get();

        $view = match ($type) {
            'facture' => 'back.dossiers.select_devis',
            'attestation_realisation' => 'back.dossiers.select_devis_attestation',
            'attestation_signataire' => 'back.dossiers.select_devis_attestation_signataire',
            'cahier_des_charges' => 'back.dossiers.select_devis_cahier',
        };

        return view($view, compact(
            'activity',
            'society',
            'devisList',
            'type'
        ));
    }
    public function selectDevisForAttestation(Request $request, $activity, $society)
    {
        // ✅ NORMALISER
        $normalizedSociety = $this->normalizeSociety($society);

        // ✅ Base Query
        $query = Document::query()
            ->where('activity', $activity)
            ->where('society', $normalizedSociety)
            ->where('type', 'devis');

        // ✅ Recherche si champ rempli
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('reference_devis', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhere('nom_residence', 'like', "%{$search}%");
            });
        }

        // ✅ Résultat
        $devisList = $query->latest()->get();

        return view('back.dossiers.select_devis_attestation', compact(
            'devisList',
            'activity',
            'society'
        ));
    }


    public function selectDevisForSignataire(Request $request, $activity, $society)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        $query = Document::query()
            ->where('activity', $activity)
            ->where('society', $normalizedSociety)
            ->where('type', 'devis');

        // 🔍 Recherche
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('reference_devis', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhere('nom_residence', 'like', "%{$search}%")
                    ->orWhere('adresse_travaux', 'like', "%{$search}%");
            });
        }

        $devisList = $query->latest()->get();

        return view('back.dossiers.select_devis_attestation_signataire', compact(
            'devisList',
            'activity',
            'society'
        ));
    }
    public function selectDevisForCahier(Request $request, $activity, $society)
    {
        $normalizedSociety = $this->normalizeSociety($society);

        $query = Document::query()
            ->where('activity', $activity)
            ->where('society', $normalizedSociety)
            ->where('type', 'devis');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('reference_devis', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhere('nom_residence', 'like', "%{$search}%")
                    ->orWhere('adresse_travaux', 'like', "%{$search}%");
            });
        }

        $devisList = $query->latest()->get();

        return view('back.dossiers.select_devis_cahier', compact(
            'devisList',
            'activity',
            'society'
        ));
    }



    public function selectFactureForRapport(Request $request, $activity, $society)
    {
        // ✅ NORMALISER
        $normalizedSociety = $this->normalizeSociety($society);

        // ✅ Base query
        $query = Document::query()
            ->where('society', $normalizedSociety)
            ->where('activity', $activity)
            ->where('type', 'facture');

        // ✅ Recherche (si search existe)
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('reference_facture', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        // ✅ Résultat
        $factures = $query->orderByDesc('created_at')->get();

        return view('back.dossiers.select_facture_for_rapport', [
            'activity' => $activity,
            'society' => $society,          // on garde la valeur d'URL pour les routes
            'factures' => $factures,
            'type' => 'rapport',
        ]);
    }

    // =========================================================================
    // CRÉATION DE DOCUMENTS
    // =========================================================================

    public function create($activity, $society, $type)
    {
        // Normaliser la société
        $normalizedSociety = $this->normalizeSociety($society);

        $parent = null;
        $parentId = request('parent_id');

        Log::info('📝 CREATE METHOD CALLED', [
            'activity' => $activity,
            'society' => $society,
            'normalized_society' => $normalizedSociety,
            'type' => $type,
            'parent_id' => $parentId
        ]);

        // Si un parent_id est fourni, chercher le document
        if ($parentId) {
            $parent = Document::find($parentId);

            if (!$parent) {
                Log::error('Parent document not found:', ['parent_id' => $parentId]);
                return redirect()->back()
                    ->with('error', 'Document parent non trouvé');
            }

            // Vérifier avec la société normalisée
            if ($parent->activity !== $activity || $parent->society !== $normalizedSociety) {
                Log::error('Parent document mismatch:', [
                    'parent' => $parent->activity . '/' . $parent->society,
                    'requested' => $activity . '/' . $normalizedSociety
                ]);
                return redirect()->back()
                    ->with('error', 'Le document parent ne correspond pas à l\'activité/société sélectionnée');
            }
        }

        // Si pas de parent mais qu'on veut créer une facture/attestation
        if (!$parent && in_array($type, ['facture', 'attestation_realisation', 'attestation_signataire', 'cahier_des_charges', 'rapport'])) {
            Log::warning('No parent provided for document type that requires one:', [
                'type' => $type,
                'activity' => $activity,
                'society' => $normalizedSociety
            ]);

            // Rediriger vers la sélection du devis
            return redirect()->route('back.document.select-devis', [
                'activity' => $activity,
                'society' => $society,
                'type' => $type
            ]);
        }

        // Créer un document vide
        $document = new Document();

        // Pré-remplir avec les données du parent si c'est une facture
        if (isset($parent) && $type === 'facture') {
            $document->fill($parent->toArray());
            $document->parent_id = $parent->id;
        }

        // Déterminer la vue du formulaire spécifique
        $templateView = $this->getFormView($type);

        // Vérifier que la vue existe
        if (!view()->exists($templateView)) {
            Log::error('Template view not found for create method:', [
                'template' => $templateView,
                'type' => $type
            ]);

            // Fallback à l'ancien système
            $fallbackView = 'back.dossiers.form';
            if (view()->exists($fallbackView)) {
                Log::warning('Using fallback view for create', ['fallback' => $fallbackView]);
                return view($fallbackView, compact('activity', 'society', 'type', 'document', 'parent'));
            }

            abort(404, "Vue de formulaire non trouvée: {$templateView}");
        }

        Log::info('✅ Using template view for create', ['template' => $templateView]);

        return view('back.documents.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => $type,
            'document' => $document,
            'parent' => $parent,
            'templateView' => $templateView, // ← TRÈS IMPORTANT !
        ]);
    }



    private function getFormView($type)
    {
        // Mapping des types vers les vues
        $views = [
            'devis' => 'back.documents.forms.devis',
            'facture' => 'back.documents.forms.facture',
            'attestation_realisation' => 'back.documents.forms.attestation_realisation',
            'attestation_signataire' => 'back.documents.forms.attestation-signataire',
            'cahier_des_charges' => 'back.documents.forms.cahier-des-charges',
            'rapport' => 'back.documents.forms.rapport',
        ];

        $view = $views[$type] ?? 'back.documents.forms.devis';

        // Vérifier l'existence
        if (!$this->checkViewExists($view)) {
            Log::error("View not found: {$view}");
            return 'back.documents.forms.devis'; // Fallback
        }

        return $view;
    }

    /**
     * Liste les vues de formulaire disponibles
     */
    private function getAvailableFormViews()
    {
        $basePath = resource_path('views/back/documents/forms');
        $views = [];

        if (is_dir($basePath)) {
            $files = scandir($basePath);
            foreach ($files as $file) {
                if (str_ends_with($file, '.blade.php')) {
                    $type = str_replace('.blade.php', '', $file);
                    $views[] = "back.documents.forms.{$type}";
                }
            }
        }

        return $views;
    }

    /**
     * Vérifie si une vue existe (méthode existante que vous avez déjà)
     */
    public function createFacture($activity, $society, $devisId)
    {
        // Normaliser la société
        $normalizedSociety = $this->normalizeSociety($society);

        $devis = Document::where('id', $devisId)
            ->where('type', 'devis')
            ->firstOrFail();

        $lastFacture = Document::where('activity', $activity)
            ->where('society', $normalizedSociety)
            ->where('type', 'facture')
            ->latest()
            ->first();

        $numero = $this->generateNextNumber($activity, $society, 'facture', $lastFacture);

        // Créer un document vide pour la facture
        $document = new Document();
        $document->parent_id = $devis->id;
        $document->numero = $numero;

        // Pré-remplir avec les données du devis
        $document->fill($devis->toArray());

        // Réinitialiser certains champs
        $document->type = 'facture';
        $document->reference_facture = null;
        $document->date_facture = null;
        $document->file_path = null;

        // Déterminer la vue du formulaire spécifique
        $templateView = $this->getFormView('facture');

        return view('back.documents.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => 'facture',
            'document' => $document,
            'parent' => $devis,
            'templateView' => $templateView,
            'numero' => $numero, // Optionnel : si vous voulez garder cette info
        ]);
    }

    public function createAttestationFromDevis($activity, $society, Document $devis)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        $lastAttestation = Document::where('activity', $activity)
            ->where('society', $normalizedSociety)  // ← CORRIGER
            ->where('type', 'attestation_realisation')
            ->latest()
            ->first();

        $numero = $this->generateNextNumber($activity, $society, 'attestation_realisation', $lastAttestation);
        $templateView = $this->getFormView('attestation_realisation');

        return view('back.documents.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => 'attestation_realisation',
            'parent' => $devis,
            'document' => null,
            'templateView' => $templateView,
            'numero' => $numero,
        ]);
    }

    public function createAttestationSignataireFromDevis($activity, $society, Document $devis)
    {
        $normalizedSociety = $this->normalizeSociety($society);

        $lastAttestation = Document::where('activity', $activity)
            ->where('society', $normalizedSociety)
            ->where('type', 'attestation_signataire')
            ->latest()
            ->first();

        $numero = $this->generateNextNumber($activity, $society, 'attestation_signataire', $lastAttestation);

        $document = new Document();
        $document->parent_id = $devis->id;
        $document->numero = $numero;
        $document->type = 'attestation_signataire';
        $document->fill($devis->toArray());

        $templateView = $this->getFormView('attestation_signataire');

        return view('back.documents.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => 'attestation_signataire',
            'parent' => $devis,
            'document' => $document,
            'templateView' => $templateView,
            'numero' => $numero,
        ]);
    }

    public function createCahierDesChargesFromDevis($activity, $society, Document $devis)
    {
        $normalizedSociety = $this->normalizeSociety($society);

        $lastCahier = Document::where('activity', $activity)
            ->where('society', $normalizedSociety)
            ->where('type', 'cahier_des_charges')
            ->latest()
            ->first();

        $numero = $this->generateNextNumber($activity, $society, 'cahier_des_charges', $lastCahier);

        $document = new Document();
        $document->parent_id = $devis->id;
        $document->numero = $numero;
        $document->type = 'cahier_des_charges';
        $document->fill($devis->toArray());

        $templateView = $this->getFormView('cahier_des_charges');

        return view('back.documents.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => 'cahier_des_charges',
            'parent' => $devis,
            'document' => $document,
            'templateView' => $templateView,
            'numero' => $numero,
        ]);
    }
    public function createRapportFromFacture(string $activity, string $society, int $factureId)
    {
        $normalizedSociety = $this->normalizeSociety($society);
        $facture = Document::findOrFail($factureId);

        // Vérifications basiques
        if ($facture->type !== 'facture') {
            abort(404, 'Pas une facture');
        }

        // Créer un document vide (tout viendra du parent)
        $document = new Document();
        $document->type = 'rapport';
        $document->parent_id = $facture->id;

        // Aucun champ à pré-remplir dans le formulaire
        // Tout sera géré dans store()

        $templateView = $this->getFormView('rapport');

        return view('back.documents.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => 'rapport',
            'parent' => $facture,
            'document' => $document,
            'templateView' => $templateView,
        ]);
    }
    // =========================================================================
    // ENREGISTREMENT ET MISE À JOUR
    // =========================================================================

    public function store(Request $request, $activity, $society, $type)
    {
        // Normaliser la société
        $normalizedSociety = $this->normalizeSociety($society);

        Log::info('📝 STORE METHOD - Rapport simple', [
            'activity' => $activity,
            'society' => $society,
            'type' => $type,
            'parent_id' => $request->parent_id ?? 'null',
        ]);

        return DB::transaction(function () use ($request, $activity, $society, $normalizedSociety, $type) {
            $data = $request->all();

            // 1. TROUVER LA FACTURE PARENT
            $parentDocument = null;
            if (!empty($data['parent_id'])) {
                $parentDocument = Document::find($data['parent_id']);

                if ($parentDocument) {
                    Log::info('📋 Facture parent trouvée', [
                        'id' => $parentDocument->id,
                        'reference' => $parentDocument->reference,
                        'type' => $parentDocument->type
                    ]);

                    // 2. COPIER TOUTES LES DONNÉES DE LA FACTURE
                    $parentData = $parentDocument->toArray();

                    // Fusionner toutes les données du parent
                    foreach ($parentData as $key => $value) {
                        // Ne pas copier certains champs
                        $excludedFields = ['id', 'created_at', 'updated_at', 'type', 'numero', 'reference'];

                        if (!in_array($key, $excludedFields) && $value !== null) {
                            $data[$key] = $value;
                        }
                    }
                }
            }

            // 3. CHAMPS OBLIGATOIRES POUR TOUS LES DOCUMENTS
            // GÉNÉRER LA RÉFÉRENCE EN PREMIER - C'EST LÀ QUE ÇA BLOQUE !
            $data['reference'] = $data['reference'] ?? $this->generateReference($normalizedSociety, $type);
            $data['society'] = $normalizedSociety;
            $data['activity'] = $activity;
            $data['type'] = $type;
            $data['user_id'] = auth()->id();

            // Conserver le parent_id
            if (!empty($data['parent_id'])) {
                $data['parent_id'] = $data['parent_id'];
            }

            // 4. NUMÉROTATION
            if (!isset($data['numero']) && isset($data['numero_custom'])) {
                $data['numero'] = $data['numero_custom'];
            } elseif (!isset($data['numero'])) {
                $lastDocument = Document::where('activity', $activity)
                    ->where('society', $normalizedSociety)
                    ->where('type', $type)
                    ->latest()
                    ->first();
                $data['numero'] = $this->generateNextNumber($activity, $normalizedSociety, $type, $lastDocument);
            }

            // 5. FILTRER LES CHAMPS FILLABLE
            $model = new Document();
            $fillable = $model->getFillable();

            // Ajouter 'reference' si ce n'est pas dans fillable (au cas où)
            if (!in_array('reference', $fillable)) {
                $fillable[] = 'reference';
            }

            Log::debug('📋 Champs fillable', $fillable);
            Log::debug('📋 Données reçues', array_keys($data));

            $filteredData = [];
            foreach ($data as $key => $value) {
                if (in_array($key, $fillable)) {
                    $filteredData[$key] = $value;
                }
            }

            // VÉRIFIER QUE LA RÉFÉRENCE EST BIEN PRÉSENTE
            if (!isset($filteredData['reference']) || empty($filteredData['reference'])) {
                $filteredData['reference'] = $this->generateReference($normalizedSociety, $type);
            }

            Log::info('📋 Données finales du rapport', [
                'fields_count' => count($filteredData),
                'has_parent' => !empty($filteredData['parent_id']),
                'reference' => $filteredData['reference'] ?? 'null',
                'type' => $filteredData['type'] ?? 'null',
                'numero' => $filteredData['numero'] ?? 'null'
            ]);

            // 6. CRÉER LE DOCUMENT
            $document = Document::create($filteredData);

            Log::info('✅ Document créé avec succès', [
                'id' => $document->id,
                'reference' => $document->reference,
                'type' => $document->type,
                'parent_id' => $document->parent_id,
                'society' => $document->society
            ]);

            // 7. GÉNÉRER LE PDF
            try {
                $template = $this->getPdfView($document);
                Log::info('🔄 Génération du PDF', [
                    'document_id' => $document->id,
                    'template' => $template
                ]);

                $pdfPath = $this->pdfFillService->generateAndSavePdf($document, $template);

                // Mettre à jour le document avec le chemin du PDF
                $document->update(['file_path' => $pdfPath]);

                Log::info('📄 PDF généré et sauvegardé', [
                    'document_id' => $document->id,
                    'pdf_path' => $pdfPath
                ]);

                // 8. TÉLÉCHARGER LE PDF
                return $this->downloadPDF($activity, $society, $type, $document->id);

            } catch (\Exception $e) {
                Log::error('❌ Échec de la génération du PDF', [
                    'document_id' => $document->id,
                    'error' => $e->getMessage()
                ]);

                return redirect()
                    ->route('back.document.show', [
                        'activity' => $activity,
                        'society' => $society,
                        'type' => $type,
                        'document' => $document->id
                    ])
                    ->with('success', 'Document créé avec succès !')
                    ->with('warning', 'Le PDF n\'a pas pu être généré : ' . $e->getMessage());
            }
        });
    }



    private function generateReference($society, $type)
    {
        $prefixes = [
            'devis' => 'DEV',
            'facture' => 'FAC',
            'rapport' => 'RAP',
            'cahier_des_charges' => 'CDC',
            'attestation_realisation' => 'ATT-R',
            'attestation_signataire' => 'ATT-S'
        ];

        $prefix = $prefixes[$type] ?? 'DOC';
        $timestamp = time();
        $random = mt_rand(1000, 9999);

        return $prefix . '-' . strtoupper(substr($society, 0, 3)) . '-' . $timestamp . '-' . $random;
    }
    public function update(Request $request, $activity, $society, $type, Document $document)
    {
        try {
            Log::info('📝 Update method called', ['document_id' => $document->id]);

            $formData = $request->all();

            // --- Gérer les documents liés ---
            foreach (['linked_devis', 'linked_facture'] as $linkedField) {
                if (!empty($formData[$linkedField])) {
                    $linked = Document::where('reference', $formData[$linkedField])->first();
                    if ($linked) {
                        $linkedData = $linked->only($linked->getFillable());
                        $formData = array_merge($linkedData, $formData);
                    }
                }
            }


            // --- Filtrer seulement les champs fillables ---
            $fillableFields = $document->getFillable();
            $filteredData = [];
            foreach ($fillableFields as $field) {
                if (isset($formData[$field])) {
                    $filteredData[$field] = $formData[$field];
                }
            }

            // --- Mettre à jour le document en base ---
            $document->update($filteredData);
            Log::info('✅ Document updated', ['document_id' => $document->id]);

            // --- Génération du PDF ---
            try {
                // Construire le chemin de la vue Blade PDF
                $template = "pdf.{$society}.{$activity}.{$type}";

                // Vérifier si la vue existe
                if (!view()->exists($template)) {
                    Log::error('❌ Vue PDF non trouvée', ['template' => $template]);
                } else {
                    // Génération et sauvegarde PDF via le service
                    $pdfPath = $this->pdfFillService->generateAndSavePdf($document, $template);
                    Log::info('✅ PDF généré et sauvegardé', ['file_path' => $pdfPath]);
                }
            } catch (\Exception $e) {
                Log::error('❌ Erreur génération PDF', ['error' => $e->getMessage()]);
            }

            return back()->with('success', 'Document mis à jour et PDF généré avec succès');

        } catch (\Exception $e) {
            Log::error('❌ UPDATE DOCUMENT ERROR', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors('Erreur lors de la mise à jour du document: ' . $e->getMessage());
        }
    }


    // =========================================================================
    // GESTION DES DOCUMENTS EXISTANTS
    // =========================================================================

    public function listDocuments(Request $request, $activity, $society, $type)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        // 🔎 Récupérer la recherche (GET ?search=...)
        $search = trim((string) $request->query('search', ''));

        // Base query
        $query = Document::where('activity', $activity)
            ->where('society', $normalizedSociety);

        // Filtre type
        if ($type !== 'all') {
            $query->where('type', $type);
        }

        // ✅ Filtre recherche (minimum 2 caractères)
        if ($search !== '' && mb_strlen($search) >= 2) {
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'LIKE', "%{$search}%")
                    ->orWhere('nom_residence', 'LIKE', "%{$search}%")
                    ->orWhere('adresse_travaux', 'LIKE', "%{$search}%");
            });
        }

        // Documents
        $documents = $query->with(['user', 'parent'])
            ->latest()
            ->paginate(20)
            ->withQueryString(); // ✅ garde search/type/activity/society dans pagination

        // Statistiques (mêmes que toi)
        if ($type === 'all') {
            $stats = [
                'total' => Document::where('activity', $activity)->where('society', $normalizedSociety)->count(),
                'devis' => Document::where('activity', $activity)->where('society', $normalizedSociety)->where('type', 'devis')->count(),
                'factures' => Document::where('activity', $activity)->where('society', $normalizedSociety)->where('type', 'facture')->count(),
                'rapports' => Document::where('activity', $activity)->where('society', $normalizedSociety)->where('type', 'rapport')->count(),
                'cahiers' => Document::where('activity', $activity)->where('society', $normalizedSociety)->where('type', 'cahier_des_charges')->count(),
                'attestations' => Document::where('activity', $activity)->where('society', $normalizedSociety)
                    ->whereIn('type', ['attestation_realisation', 'attestation_signataire'])->count(),
            ];
        } else {
            $stats = [
                'total' => Document::where('activity', $activity)->where('society', $normalizedSociety)->where('type', $type)->count(),
                'ce_mois' => Document::where('activity', $activity)->where('society', $normalizedSociety)->where('type', $type)
                    ->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
                'cette_semaine' => Document::where('activity', $activity)->where('society', $normalizedSociety)->where('type', $type)
                    ->where('created_at', '>=', now()->subWeek())->count(),
            ];
        }

        return view('back.dossiers.list_documents', compact(
            'documents',
            'activity',
            'society',
            'type',
            'stats',
            'search' // ✅ utile si tu veux l’afficher dans le blade
        ));
    }
    public function searchDocument(Request $request, $activity, $society, $type)
    {
        $request->validate([
            'search' => 'required|string|min:2'
        ]);

        // Définir $search AVANT de l'utiliser
        $search = $request->search;

        // Normaliser la société
        $normalizedSociety = $this->normalizeSociety($society);

        $documents = Document::where('activity', $activity)
            ->where('society', $normalizedSociety)
            ->where('type', $type)
            ->where(function ($query) use ($search) {
                $query->where('reference', 'LIKE', "%{$search}%")
                    ->orWhere('nom_residence', 'LIKE', "%{$search}%")
                    ->orWhere('adresse_travaux', 'LIKE', "%{$search}%");
            })
            ->with(['user', 'parent'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('back.documents.search-type', compact(
            'activity',
            'society',
            'type',
            'documents',
            'search'
        ));
    }


    private function checkViewExists($viewName)
    {
        $exists = view()->exists($viewName);
        \Log::info("View check: {$viewName} -> " . ($exists ? 'EXISTS' : 'NOT FOUND'));
        return $exists;
    }
    public function show($activity, $society, $type, Document $document)
    {
        Log::info('👁️ SHOW METHOD', [
            'activity' => $activity,
            'society' => $society,
            'type' => $type,
            'document_id' => $document->id,
            'parent_id' => $document->parent_id
        ]);

        // Récupérer le parent si nécessaire
        $parent = null;
        if ($document->parent_id) {
            $parent = Document::find($document->parent_id);
        }

        // Déterminer la vue du formulaire spécifique
        $templateView = $this->getFormView($type);

        // Vérifier que la vue existe
        if (!view()->exists($templateView)) {
            Log::error('Template view not found for show method:', [
                'template' => $templateView,
                'type' => $type,
                'document_id' => $document->id
            ]);

            // Fallback à l'ancien système si nécessaire
            $fallbackView = 'back.dossiers.form';
            if (view()->exists($fallbackView)) {
                Log::warning('Using fallback view', ['fallback' => $fallbackView]);
                return view($fallbackView, [
                    'activity' => $activity,
                    'society' => $society,
                    'type' => $type,
                    'document' => $document,
                    'parent' => $parent,
                ]);
            }

            abort(404, "Vue de formulaire non trouvée: {$templateView}");
        }

        Log::info('✅ Using template view', ['template' => $templateView]);

        return view('back.documents.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => $type,
            'document' => $document,
            'parent' => $parent,
            'templateView' => $templateView, // ← TRÈS IMPORTANT !
        ]);
    }

    public function previewPDF($activity, $society, $type, $document)
    {
        $document = Document::findOrFail($document);

        if (!$document->file_path) {
            Log::warning('📄 PDF non trouvé pour prévisualisation', ['document_id' => $document->id]);

            // Regénérer le PDF si nécessaire
            try {
                $pdfPath = $this->generateDocumentPDF($document, $activity, $society, $type);
                $document->update(['file_path' => $pdfPath]);
            } catch (\Exception $e) {
                return back()->with('error', 'PDF non disponible et impossible à générer');
            }
        }

        $path = storage_path('app/public/' . str_replace('storage/', '', $document->file_path));

        if (!file_exists($path)) {
            return back()->with('error', 'Fichier PDF introuvable');
        }

        return response()->file($path);
    }
    public function edit($activity, $society, $type, Document $document)
    {
        // Normaliser la société
        $normalizedSociety = $this->normalizeSociety($society);

        // Vérifier avec la société normalisée
        if ($document->activity !== $activity || $document->society !== $normalizedSociety || $document->type !== $type) {
            abort(404);
        }

        // Déterminer la vue du formulaire spécifique
        $templateView = $this->getFormView($type);

        return view('back.documents.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => $type,
            'parent' => $document->parent,
            'document' => $document,
            'templateView' => $templateView, // ← IMPORTANT !
        ]);
    }
    public function destroy($activity, $society, $type, Document $document)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        try {
            // Vérifier avec la société normalisée
            if ($document->activity !== $activity || $document->society !== $normalizedSociety || $document->type !== $type) {
                abort(404);
            }

            // Vérifier s'il a des documents enfants
            if ($document->children()->count() > 0) {
                return back()->withErrors('Impossible de supprimer ce document : il a des documents liés.');
            }

            // Supprimer le fichier PDF si existe
            if ($document->file_path && Storage::disk('public')->exists(str_replace('storage/', '', $document->file_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $document->file_path));
            }

            $document->delete();

            Log::info('✅ Document supprimé', ['document_id' => $document->id]);

            return redirect()->route('back.document.list', [
                'activity' => $activity,
                'society' => $society,
                'type' => $type
            ])->with('success', 'Document supprimé avec succès !');

        } catch (\Exception $e) {
            Log::error('❌ Erreur suppression document', [
                'error' => $e->getMessage(),
                'document_id' => $document->id
            ]);

            return back()->withErrors('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    // =========================================================================
    // MÉTHODES UTILITAIRES NOUVELLES
    // =========================================================================

    /**
     * Télécharger le fichier joint d'un document
     */
    public function downloadPDF($activity, $society, $type, $documentId)
    {
        $document = Document::findOrFail($documentId);

        if (!$document->file_path) {
            return back()->with('error', 'PDF non disponible');
        }

        $path = storage_path('app/public/' . str_replace('storage/', '', $document->file_path));

        if (!file_exists($path)) {
            return back()->with('error', 'Fichier PDF introuvable');
        }

        $filename = "{$type}_{$document->reference}_{$document->society}_{$document->activity}.pdf";

        return response()->download($path, $filename);
    }
    /**
     * Changer le statut d'un document
     */
    public function changeStatus(Request $request, $activity, $society, $type, Document $document)
    {
        $request->validate([
            'statut' => 'required|string|in:brouillon,valide,envoye,paye,annule'
        ]);

        $ancienStatut = $document->statut;
        $document->update(['statut' => $request->statut]);

        Log::info('🔄 Changement statut document', [
            'document_id' => $document->id,
            'ancien' => $ancienStatut,
            'nouveau' => $request->statut,
            'user_id' => auth()->id()
        ]);

        return back()->with('success', "Statut changé de {$ancienStatut} à {$request->statut}");
    }

    /**
     * Dupliquer un document
     */
    public function duplicate($activity, $society, $type, Document $document)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        $lastDocument = Document::where('activity', $activity)
            ->where('society', $normalizedSociety)  // ← CORRIGER
            ->where('type', $type)
            ->latest()
            ->first();

        $numero = $this->generateNextNumber($activity, $society, $type, $lastDocument);

        // Créer la copie
        $copy = $document->replicate();
        $copy->numero = $numero;
        $copy->date = now();
        $copy->statut = 'brouillon';
        $copy->parent_id = null;
        $copy->file_path = null;
        $copy->save();

        Log::info('📋 Document dupliqué', [
            'original_id' => $document->id,
            'copy_id' => $copy->id,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('back.document.edit', [
            'activity' => $activity,
            'society' => $society,
            'type' => $type,
            'document' => $copy->id
        ])->with('success', 'Document dupliqué avec succès !');
    }

    // =========================================================================
    // MÉTHODES PRIVÉES PDF (de l'ancien contrôleur)
    // =========================================================================

    /**
     * Génère un PDF dynamique à partir d'un template Blade

 * Génère un PDF dynamique à partir d'un template Blade
 */
    /**
     * Génère un PDF dynamique à partir d'un template Blade
     */
    public function generatePDF($activity, $society, $type, Document $document)
    {
        try {
            // Déterminer le template
            $template = "pdf.{$society}.{$activity}.{$type}";

            // Vérifier si le template existe
            if (!view()->exists($template)) {
                throw new \Exception("Le template PDF {$template} est introuvable.");
            }

            // Générer le PDF
            $pdf = Pdf::loadView($template, compact('document'))
                ->setPaper('a4', 'portrait');

            // Définir un nom de fichier unique
            $filename = $this->generatePdfFilename($document, $society, $activity, $type);

            // Chemin de stockage
            $storagePath = "documents/{$society}/{$activity}/{$type}/{$filename}";

            // Créer le dossier s'il n'existe pas
            if (!Storage::disk('public')->exists(dirname($storagePath))) {
                Storage::disk('public')->makeDirectory(dirname($storagePath), 0755, true);
            }

            // Sauvegarder le fichier
            Storage::disk('public')->put($storagePath, $pdf->output());

            // Mettre à jour le chemin dans le document
            $document->file_path = "storage/{$storagePath}";
            $document->save();

            return redirect()->back()->with('success', 'PDF généré et sauvegardé avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération du PDF', [
                'error' => $e->getMessage(),
                'document_id' => $document->id,
            ]);

            return redirect()->back()->withErrors('Erreur lors de la génération du PDF : ' . $e->getMessage());
        }
    }

    /**
     * Version améliorée de generateDocumentPDF avec plus de logs
     */
    private function generateDocumentPDF($document, $activity, $society, $type)
    {
        try {
            // 1. Déterminer le template
            $template = $this->determinePdfTemplate($society, $activity, $type);
            Log::info('📋 Template utilisé', ['template' => $template]);

            // 2. Préparer les données
            $pdfData = [
                'document' => $document,
                'activity' => $activity,
                'society' => $society,
                'type' => $type,
                'date' => now()->format('d/m/Y'),
            ];

            $pdf = Pdf::loadView($template, $pdfData);
            $content = $pdf->output();

            if (!$content || strlen($content) < 100) {
                throw new \Exception("Le PDF est vide !");
            }

            $pdf = Pdf::loadView($template, $pdfData)
                ->setPaper('A4', 'portrait')
                ->setOption('defaultFont', 'Helvetica')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', false);

            // 4. Créer un nom de fichier unique
            $reference = $document->reference_devis ??
                $document->reference_facture ??
                $document->reference ??
                'doc_' . $document->id;

            // Nettoyer le nom
            $cleanRef = preg_replace('/[^a-zA-Z0-9_-]/', '_', $reference);
            $timestamp = date('Ymd_His');
            $filename = "{$type}_{$cleanRef}_{$timestamp}.pdf";

            // 5. Définir le chemin de stockage
            $storageDir = "documents/{$document->society}/{$activity}/{$type}";

            // Créer le dossier s'il n'existe pas
            if (!Storage::disk('public')->exists($storageDir)) {
                Storage::disk('public')->makeDirectory($storageDir, 0755, true);
            }

            // 6. Sauvegarder le PDF
            $fullStoragePath = "{$storageDir}/{$filename}";
            Storage::disk('public')->put($fullStoragePath, $pdf->output());

            // 7. Vérifier la sauvegarde
            $fileExists = Storage::disk('public')->exists($fullStoragePath);
            $fileSize = Storage::disk('public')->size($fullStoragePath);

            if (!$fileExists || $fileSize === 0) {
                throw new \Exception("Le fichier PDF n'a pas été créé (taille: {$fileSize} octets)");
            }

            // 8. Retourner le chemin POUR LA BASE DE DONNÉES
            // Format: "storage/documents/society/activity/type/filename.pdf"
            $dbPath = "storage/{$fullStoragePath}";

            Log::info('✅ PDF créé', [
                'filename' => $filename,
                'db_path' => $dbPath,
                'storage_path' => $fullStoragePath,
                'file_size' => $fileSize,
                'file_exists' => $fileExists
            ]);

            return $dbPath;

        } catch (\Exception $e) {
            Log::error('❌ Erreur generateDocumentPDF', [
                'document_id' => $document->id,
                'error' => $e->getMessage(),
                'template' => $template ?? 'non défini'
            ]);
            throw $e;
        }
    }

    private function getPdfView(Document $document): string
    {
        $activity = $document->activity;
        $type = $document->type;

        // 🔎 On récupère la société via son code
        $societe = Societe::findByCode($document->society);

        // 📁 Dossier réel à utiliser
        $folder = $societe?->pdf_folder ?? $document->society;

        // 1️⃣ Template spécifique société
        $specificView = "pdf.{$folder}.{$activity}.{$type}";
        if (view()->exists($specificView)) {
            return $specificView;
        }

        // 2️⃣ Fallback vers default
        $defaultView = "pdf.default.{$activity}.{$type}";
        if (view()->exists($defaultView)) {
            return $defaultView;
        }

        // 3️⃣ Si rien trouvé
        throw new \Exception(
            "Aucun template trouvé pour société [{$folder}] activité [{$activity}] type [{$type}]"
        );
    }


    /**
     * 🔍 Cherche des templates alternatifs
     */
    private function findAlternativePdfViews(Document $document, string $templateFolder): array
    {
        $alternatives = [];
        $basePath = resource_path('views/pdf');

        // Chemins possibles à explorer
        $searchPaths = [
            // 1. Même société, même activité, type différent
            ["{$basePath}/{$templateFolder}/{$document->activity}"],
            // 2. Même société, toutes activités
            ["{$basePath}/{$templateFolder}"],
            // 3. Société 'default', même activité
            ["{$basePath}/default/{$document->activity}"],
            // 4. Société 'default', toutes activités
            ["{$basePath}/default"],
        ];

        foreach ($searchPaths as $paths) {
            foreach ($paths as $path) {
                if (is_dir($path)) {
                    $files = scandir($path);
                    foreach ($files as $file) {
                        if (str_ends_with($file, '.blade.php')) {
                            $type = str_replace('.blade.php', '', $file);
                            $relativePath = str_replace(resource_path('views') . '/', '', $path);
                            $alternatives[] = str_replace('/', '.', $relativePath) . '.' . $type;
                        }
                    }
                }
            }
        }

        return array_unique($alternatives);
    }



    //ajout 

    private function getAvailablePdfViews()
    {
        $views = [];
        $basePath = resource_path('views/pdf');


        if (!is_dir($basePath)) {
            Log::warning('📁 Dossier PDF non trouvé', ['path' => $basePath]);
            return [];
        }

        // Lister tous les dossiers de sociétés
        $societyDirs = array_filter(scandir($basePath), function ($item) use ($basePath) {
            return is_dir($basePath . '/' . $item) && !in_array($item, ['.', '..']);
        });

        Log::info('📂 Dossiers PDF trouvés', ['societes' => $societyDirs]);

        foreach ($societyDirs as $society) {
            $societyPath = "{$basePath}/{$society}";

            // Lister les dossiers d'activités
            $activityDirs = array_filter(scandir($societyPath), function ($item) use ($societyPath) {
                return is_dir($societyPath . '/' . $item) && !in_array($item, ['.', '..']);
            });

            foreach ($activityDirs as $activity) {
                $typesPath = "{$societyPath}/{$activity}";

                if (is_dir($typesPath)) {
                    $files = scandir($typesPath);
                    foreach ($files as $file) {
                        if (str_ends_with($file, '.blade.php')) {
                            $type = str_replace('.blade.php', '', $file);
                            $view = "pdf.{$society}.{$activity}.{$type}";
                            $views[] = $view;

                            Log::debug('📄 Template PDF trouvé', ['view' => $view]);
                        }
                    }
                }
            }
        }


        sort($views);

        Log::info('📚 Templates PDF disponibles', [
            'total' => count($views),
            'societes' => $societyDirs,
            'preview' => array_slice($views, 0, 5)
        ]);

        return $views;
    }


    /**
     * Prépare les données pour le template PDF
     */
    private function preparePdfData(Document $document): array
    {
        // Récupérer toutes les données du document
        $documentData = $document->toArray();

        // Fusionner hiérarchiquement avec les parents
        $documentData = $this->mergeParentData($document, $documentData);

        // Formater les données
        $documentData = $this->formatDocumentData($documentData);

        // Ajouter des données calculées
        $documentData = $this->addCalculatedData($documentData);

        return [
            'document' => $document,
            'data' => $documentData,
            'activity' => $document->activity,
            'society' => $document->society,
            'type' => $document->type,
            'today' => now()->format('d/m/Y'),
            'user' => Auth::user()
        ];
    }

    /**
     * Fusionne les données des documents parents
     */
    private function mergeParentData(Document $document, array $data): array
    {
        $current = $document;

        while ($current->parent) {
            $parentData = $current->parent->toArray();

            // Fusionner sans écraser les valeurs existantes
            foreach ($parentData as $key => $value) {
                if (!isset($data[$key]) || empty($data[$key])) {
                    $data[$key] = $value;
                }
            }

            $current = $current->parent;
        }

        return $data;
    }

    /**
     * Formate les données (dates, montants, etc.)
     */
    private function formatDocumentData(array $data): array
    {
        // Formater les dates
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'date_') && $value) {
                try {
                    $data[$key . '_formatted'] = \Carbon\Carbon::parse($value)->format('d/m/Y');
                } catch (\Exception $e) {
                    $data[$key . '_formatted'] = $value;
                }
            }

            // Formater les montants
            if (
                str_contains($key, 'montant') ||
                str_contains($key, 'prix') ||
                str_contains($key, 'total') ||
                in_array($key, ['prime_cee', 'reste_a_charge', 'tva', 'ht', 'ttc'])
            ) {

                if (is_numeric($value)) {
                    $data[$key . '_formatted'] = number_format($value, 2, ',', ' ') . ' €';
                }
            }
        }

        return $data;
    }

    /**
     * Ajoute des données calculées
     */
    private function addCalculatedData(array $data): array
    {
        // Calcul du reste à charge si non défini
        if (isset($data['montant_ttc']) && isset($data['prime_cee'])) {
            $reste = $data['montant_ttc'] - $data['prime_cee'];
            if ($reste > 0 && !isset($data['reste_a_charge'])) {
                $data['reste_a_charge'] = $reste;
                $data['reste_a_charge_formatted'] = number_format($reste, 2, ',', ' ') . ' €';
            }
        }

        // Calcul de la TVA si non défini
        if (isset($data['montant_ht']) && !isset($data['montant_tva'])) {
            $tva = $data['montant_ht'] * 0.20;
            $data['montant_tva'] = $tva;
            $data['montant_tva_formatted'] = number_format($tva, 2, ',', ' ') . ' €';
        }

        // Calcul du TTC si HT et TVA sont définis
        if (isset($data['montant_ht']) && isset($data['montant_tva']) && !isset($data['montant_ttc'])) {
            $data['montant_ttc'] = $data['montant_ht'] + $data['montant_tva'];
            $data['montant_ttc_formatted'] = number_format($data['montant_ttc'], 2, ',', ' ') . ' €';
        }

        return $data;
    }

    // =========================================================================
    // MÉTHODES UTILITAIRES PRIVÉES NOUVELLES
    // =========================================================================

    /**
     * Générer le numéro suivant pour un document
     */
    private function generateNextNumber($activity, $society, $type, $lastDocument = null)
    {
        // Normaliser la société ici aussi
        $normalizedSociety = $this->normalizeSociety($society);

        $prefixes = [
            'devis' => 'DEV',
            'facture' => 'FAC',
            'rapport' => 'RAP',
            'cahier_des_charges' => 'CDC',
            'attestation_realisation' => 'ATT-R',
            'attestation_signataire' => 'ATT-S'
        ];

        $prefix = $prefixes[$type] ?? 'DOC';
        $year = date('Y');
        $month = date('m');

        // Chercher le dernier document avec la société normalisée
        if (!$lastDocument) {
            $lastDocument = Document::where('activity', $activity)
                ->where('society', $normalizedSociety)
                ->where('type', $type)
                ->latest()
                ->first();
        }

        if ($lastDocument && preg_match('/^' . $prefix . '-\d{4}-\d{2}-(\d+)$/', $lastDocument->numero, $matches)) {
            $nextNumber = str_pad((int) $matches[1] + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . '-' . $nextNumber . '-' . $month . '-' . $year;
    }

    /**
     * Règles de validation selon le type de document
     */
    private function getValidationRules($type, $update = false)
    {
        $rules = [
            'numero' => 'required|string|max:50',
            'date' => 'required|date',
            'client_nom' => 'required|string|max:100',
            'client_email' => 'nullable|email|max:100',
            'client_telephone' => 'nullable|string|max:20',
            'adresse_travaux' => 'required|string',
            'ville' => 'required|string|max:50',
            'code_postal' => 'required|string|max:10',
            'montant_ht' => 'nullable|numeric|min:0',
            'tva' => 'nullable|numeric|min:0|max:100',
            'montant_ttc' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'observations' => 'nullable|string',
            'statut' => 'nullable|string|in:brouillon,valide,envoye,paye,annule',
            'parent_id' => 'nullable|exists:documents,id',
            'fichier_joint' => 'nullable|file|max:10240', // 10MB max
        ];

        // Règles spécifiques par type
        switch ($type) {
            case 'devis':
                $rules['validite'] = 'nullable|integer|min:1|max:365';
                break;

            case 'facture':
                $rules['date_echeance'] = 'nullable|date';
                break;
        }

        return $rules;
    }

    private function generateFilename(Document $document): string
    {
        $prefix = match ($document->type) {
            'devis' => 'DEVIS',
            'facture' => 'FACTURE',
            'rapport' => 'RAPPORT',
            'cahier_des_charges' => 'CDC',
            'attestation_realisation' => 'ATTESTATION_REAL',
            'attestation_signataire' => 'ATTESTATION_SIGN',
            default => 'DOCUMENT'
        };

        $reference = $document->reference ?? $document->numero ?? $document->id;
        $date = now()->format('Ymd');

        return "{$prefix}_{$reference}_{$date}.pdf";
    }

    /**
     * Télécharge le PDF (force le téléchargement)
     */
    public function download($activity, $society, $type, $document)
    {
        try {
            $document = Document::findOrFail($document);

            $template = match ($type) {
                'devis' => 'pdf.devis',
                'facture' => 'pdf.facture',
                'rapport' => 'pdf.rapport',
                'cahier_des_charges' => 'pdf.cahier-charges',
                default => 'pdf.document'
            };

            $data = $this->pdfFillService->prepareDocumentData($document);
            $pdf = Pdf::loadView($template, $data);
            $pdf->setPaper('A4', 'portrait');

            // ✅ download() force le téléchargement
            return $pdf->download($this->generateFilename($document));

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur de téléchargement : ' . $e->getMessage());
        }
    }

    /**
     * Regénère et affiche le PDF
     */
    public function regeneratePDF($activity, $society, $type, $document)
    {
        try {
            $document = Document::findOrFail($document);

            // Utiliser TON service pour générer ET sauvegarder
            $path = $this->pdfFillService->generateAndSavePdf(
                $document,
                "pdf.{$type}"
            );

            // Rediriger vers l'aperçu du PDF généré
            return redirect()->route('back.document.preview', [
                'activity' => $activity,
                'society' => $society,
                'type' => $type,
                'document' => $document->id
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur régénération PDF : ' . $e->getMessage());
        }
    }


    public function uploadImages(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $imageFields = [
            'cachet_image',
            'signature_image',
            'sentinel_logo',
            'icone_1',
            'icone_2',
            'icone_3',
            'image_pompe_jetflush',
            'image_jetflush_filter',
            'image_x400',
            'image_x800',
            'image_x100',
            'image_x700',
            'image_vortex300',
            'image_vortex500'
        ];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('documents/images/' . $document->id, 'public');
                $document->$field = $path;
            }
        }

        $document->save();

        return response()->json(['success' => true]);
    }

    public function askReference($activity, $society, $type)
{
    // sécurité type autorisé (optionnel mais conseillé)
    abort_if(!in_array($type, [
        'devis',
        'facture',
        'rapport',
        'attestation_realisation',
        'attestation_signataire',
        'cahier_des_charges'
    ]), 404);

    return view('back.dossiers.ask_reference', compact('activity', 'society', 'type'));
}

public function searchByReference(Request $request, $activity, $society, $type)
{
    $request->validate([
        'reference' => ['required', 'string', 'max:255'],
    ]);

    // normalisation society (comme tu fais déjà)
    $normalizedSociety = $this->normalizeSociety($society);
    $ref = trim($request->reference);

    // ✅ mapping champ référence selon le type
    // (tu peux ajuster selon tes colonnes)
    $refField = match ($type) {
        'devis' => 'reference_devis',
        'facture' => 'reference_facture',
        default => 'reference', // rapport, attestations, cahier...
    };

    // ✅ Recherche document
    $doc = Document::query()
        ->where('activity', $activity)
        ->where('society', $normalizedSociety)
        ->where('type', $type)
        ->where(function ($q) use ($ref, $refField) {
            // champ principal
            $q->where($refField, $ref);

            // fallback au cas où tu utilises parfois "reference" partout
            if ($refField !== 'reference') {
                $q->orWhere('reference', $ref);
            }
        })
        ->first();

    if (!$doc) {
        return back()
            ->withInput()
            ->withErrors(['reference' => "Aucun document trouvé avec la référence '{$ref}' pour ce type."]);
    }

    // ✅ Redirection vers la page d’édition
    return redirect()->route('back.document.edit', [
        'activity' => $activity,
        'society'  => $society,   // on garde l’original en URL
        'type'     => $type,
        'document' => $doc->id,
    ])->with('success', 'Document trouvé. Vous pouvez le modifier.');
}
}

