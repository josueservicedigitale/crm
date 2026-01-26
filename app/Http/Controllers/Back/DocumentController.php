<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use App\Services\PdfFillService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Symfony\Polyfill\Intl\Normalizer\Normalizer;

class DocumentController extends Controller
{
    protected PdfFillService $pdfFillService;

    public function __construct(PdfFillService $pdfFillService)
    {
        $this->pdfFillService = $pdfFillService;
    }


    public function dashboard($activity, $society)
    {
        // Normaliser la société
        $normalizedSociety = $this->normalizeSociety($society);

        // Utiliser les noms normalisés pour les vues
        $views = [
            'energie_nova' => [  // Utiliser le nom normalisé
                'desembouage' => 'back.dossiers.nova.novadesembouageboard',
                'reequilibrage' => 'back.dossiers.nova.novaboard',
            ],
            'myhouse' => [  // Utiliser le nom normalisé
                'desembouage' => 'back.dossiers.house.housedesembouageboard',
                'reequilibrage' => 'back.dossiers.house.houseboard',
            ],
        ];

        // Vérifier avec le nom normalisé
        abort_if(!isset($views[$normalizedSociety][$activity]), 404);

        // Toutes les requêtes doivent utiliser le nom normalisé
        $stats = [
            'total' => Document::where('society', $normalizedSociety)  // ← ICI
                ->where('activity', $activity)
                ->count(),
            'devis' => Document::where('society', $normalizedSociety)
                ->where('activity', $activity)
                ->where('type', 'devis')
                ->count(),
            'factures' => Document::where('society', $normalizedSociety)
                ->where('activity', $activity)
                ->where('type', 'facture')
                ->count(),
            'rapports' => Document::where('society', $normalizedSociety)
                ->where('activity', $activity)
                ->where('type', 'rapport')
                ->count(),
            'cahiers' => Document::where('society', $normalizedSociety)
                ->where('activity', $activity)
                ->where('type', 'cahier_des_charges')
                ->count(),
            'attestations' => Document::where('society', $normalizedSociety)
                ->where('activity', $activity)
                ->whereIn('type', ['attestation_realisation', 'attestation_signataire'])
                ->count(),
            'ce_mois' => Document::where('society', $normalizedSociety)
                ->where('activity', $activity)
                ->whereMonth('created_at', now()->month)
                ->count(),
            'cette_semaine' => Document::where('society', $normalizedSociety)
                ->where('activity', $activity)
                ->where('created_at', '>=', now()->subWeek())
                ->count(),
        ];

        // Documents récents
        $recentDocuments = Document::where('society', $normalizedSociety)
            ->where('activity', $activity)
            ->latest()
            ->take(5)
            ->get();

        // Meilleurs clients - Utiliser nom_residence ou adresse_travaux comme identifiant
        // Puisqu'il n'y a pas de colonne client_nom, on utilise nom_residence
        $topClients = Document::where('society', $normalizedSociety)
            ->where('activity', $activity)
            ->whereNotNull('nom_residence') // Utiliser nom_residence au lieu de client_nom
            ->where('nom_residence', '!=', '') // Exclure les chaînes vides
            ->selectRaw('nom_residence as client_nom, COUNT(*) as total, SUM(montant_ttc) as total_montant')
            ->groupBy('nom_residence')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Si nom_residence est vide, utiliser adresse_travaux
        if ($topClients->isEmpty()) {
            $topClients = Document::where('society', $normalizedSociety)
                ->where('activity', $activity)
                ->whereNotNull('adresse_travaux')
                ->where('adresse_travaux', '!=', '')
                ->selectRaw('SUBSTRING(adresse_travaux, 1, 50) as client_nom, COUNT(*) as total, SUM(montant_ttc) as total_montant')
                ->groupBy('adresse_travaux')
                ->orderByDesc('total')
                ->limit(5)
                ->get();
        }

        return view($views[$normalizedSociety][$activity], compact(
            'activity',
            'society',
            'recentDocuments',
            'stats',
            'topClients'
        ));
    }

    private function normalizeSociety($society)
    {
        $mapping = [
            'nova' => 'energie_nova',
            'house' => 'myhouse',
            'energie_nova' => 'energie_nova',
            'myhouse' => 'myhouse'
        ];

        return $mapping[$society] ?? $society;
    }




    public function allDashboards()
    {
        Log::info('🌐 Tous les dashboards consultés', ['user_id' => auth()->id()]);

        // Activités disponibles
        $activites = [
            'desembouage' => [
                'nom' => 'Désembouage',
                'icon' => 'fa-water',
                'color' => 'primary',
                'description' => 'Nettoyage et désembouage des circuits de chauffage'
            ],
            'reequilibrage' => [
                'nom' => 'Rééquilibrage',
                'icon' => 'fa-balance-scale',
                'color' => 'info',
                'description' => 'Rééquilibrage des circuits hydrauliques'
            ]
        ];

        // Sociétés disponibles
        $societes = [
            'nova' => [
                'nom' => 'Énergie Nova',
                'icon' => 'fa-building',
                'color' => 'success',
                'description' => 'Spécialiste en solutions énergétiques'
            ],
            'house' => [
                'nom' => 'MyHouse Solutions',
                'icon' => 'fa-home',
                'color' => 'warning',
                'description' => 'Solutions résidentielles innovantes'
            ]
        ];

        // Statistiques par activité
        $activitesAvecStats = [];
        foreach ($activites as $key => $activite) {
            $activitesAvecStats[$key] = array_merge($activite, [
                'documents_count' => Document::where('activity', $key)->count()
            ]);
        }

        // Statistiques par société
        $societesAvecStats = [];
        foreach ($societes as $key => $societe) {
            $societesAvecStats[$key] = array_merge($societe, [
                'documents_count' => Document::where('society', $key)->count()
            ]);
        }

        // Toutes les combinaisons
        $combinaisons = [];
        foreach ($activitesAvecStats as $activiteCode => $activiteInfo) {
            foreach ($societesAvecStats as $societeCode => $societeInfo) {
                $combinaisons[] = [
                    'activite_code' => $activiteCode,
                    'activite_nom' => $activiteInfo['nom'],
                    'activite_icon' => $activiteInfo['icon'],
                    'activite_color' => $activiteInfo['color'],
                    'societe_code' => $societeCode,
                    'societe_nom' => $societeInfo['nom'],
                    'societe_icon' => $societeInfo['icon'],
                    'societe_color' => $societeInfo['color'],
                    'documents_count' => Document::where('activity', $activiteCode)
                        ->where('society', $societeCode)
                        ->count(),
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
                ];
            }
        }

        // Statistiques globales
        $statsGlobales = [
            'total_documents' => Document::count(),
            'total_activites' => count($activitesAvecStats),
            'total_societes' => count($societesAvecStats),
            'total_combinaisons' => count($combinaisons),
            'documents_ce_mois' => Document::whereMonth('created_at', now()->month)->count(),
            'documents_semaine' => Document::where('created_at', '>=', now()->subWeek())->count(),
        ];

        return view('back.all-dashboards', compact(
            'activites',
            'societes',
            'activitesAvecStats',
            'societesAvecStats',
            'combinaisons',
            'statsGlobales'
        ));
    }
    // =========================================================================
    // VUES GLOBALES DE DOCUMENTS
    // =========================================================================

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

        return view('back.documents.index', compact('documents', 'stats'));
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

    public function creationRapide()
    {
        Log::info('⚡ Page création rapide consultée', ['user_id' => auth()->id()]);

        $activites = [
            'desembouage' => 'Désembouage',
            'reequilibrage' => 'Rééquilibrage'
        ];

        $societes = [
            'nova' => 'Énergie Nova',
            'house' => 'MyHouse Solutions'
        ];

        $types = [
            'devis' => 'Devis',
            'facture' => 'Facture',
            'rapport' => 'Rapport',
            'cahier_des_charges' => 'Cahier des charges',
            'attestation_realisation' => 'Attestation de réalisation',
            'attestation_signataire' => 'Attestation signataire'
        ];

        return view('back.documents.creation-rapide', compact('activites', 'societes', 'types'));
    }

    // =========================================================================
    // CHOIX ET SÉLECTION
    // =========================================================================

    public function chooseAction($activity, $society, $type)
    {
        return view('back.dossiers.choose_action', compact('activity', 'society', 'type'));
    }
    public function selectDevis($activity, $society, $type)
    {
        abort_if(!in_array($type, [
            'facture',
            'attestation_realisation',
            'attestation_signataire',
            'cahier_des_charges'
        ]), 404);

        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        $devisList = Document::where([
            'activity' => $activity,
            'society' => $normalizedSociety,  // ← CORRIGER
            'type' => 'devis',
        ])->latest()->get();

        $devisList = Document::where([
            'activity' => $activity,
            'society' => $society,
            'type' => 'devis',
        ])->latest()->get();

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

    public function selectDevisForAttestation($activity, $society)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        $devisList = Document::where([
            'activity' => $activity,
            'society' => $normalizedSociety,  // ← CORRIGER
            'type' => 'devis',
        ])->latest()->get();


        return view('back.dossiers.select_devis_attestation', compact(
            'devisList',
            'activity',
            'society'
        ));
    }

    public function selectDevisForSignataire($activity, $society)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        $devisList = Document::where([
            'activity' => $activity,
            'society' => $normalizedSociety,  // ← CORRIGER
            'type' => 'devis',
        ])->latest()->get();
        return view('back.dossiers.select_devis_attestation_signataire', compact(
            'devisList',
            'activity',
            'society'
        ));
    }
    public function selectDevisForCahier($activity, $society)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        $devisList = Document::where([
            'activity' => $activity,
            'society' => $normalizedSociety,  // ← CORRIGER
            'type' => 'devis',
        ])->latest()->get();
        return view('back.dossiers.select_devis_cahier', compact(
            'devisList',
            'activity',
            'society'
        ));
    }

    public function selectFactureForRapport($activity, $society)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        $factures = Document::where('society', $normalizedSociety)  // ← CORRIGER
            ->where('activity', $activity)
            ->where('type', 'facture')
            ->orderByDesc('created_at')
            ->get();
        return view('back.dossiers.select_facture_for_rapport', [
            'activity' => $activity,
            'society' => $society,
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

        // Log pour debug
        \Log::info('Create document request:', [
            'activity' => $activity,
            'society' => $society,
            'normalized_society' => $normalizedSociety,  // ← Ajouter ce log
            'type' => $type,
            'parent_id' => $parentId,
            'all_params' => request()->all()
        ]);

        // Si un parent_id est fourni, chercher le document
        if ($parentId) {
            $parent = Document::find($parentId);

            if (!$parent) {
                \Log::error('Parent document not found:', ['parent_id' => $parentId]);
                return redirect()->back()
                    ->with('error', 'Document parent non trouvé');
            }

            // Vérifier avec la société normalisée
            if ($parent->activity !== $activity || $parent->society !== $normalizedSociety) {
                \Log::error('Parent document mismatch:', [
                    'parent' => $parent->activity . '/' . $parent->society,
                    'requested' => $activity . '/' . $normalizedSociety
                ]);
                return redirect()->back()
                    ->with('error', 'Le document parent ne correspond pas à l\'activité/société sélectionnée');
            }
        }

        // Si pas de parent mais qu'on veut créer une facture/attestation
        if (!$parent && in_array($type, ['facture', 'attestation_realisation', 'attestation_signataire', 'cahier_des_charges', 'rapport'])) {
            \Log::warning('No parent provided for document type that requires one:', [
                'type' => $type,
                'activity' => $activity,
                'society' => $normalizedSociety  // ← Utiliser normalisé
            ]);

            // Rediriger vers la sélection du devis
            return redirect()->route('back.document.select-devis', [
                'activity' => $activity,
                'society' => $society,  // ← Garder original pour la route
                'type' => $type
            ]);
        }

        // Récupérer ou créer un document vide
        $document = new Document();
        if (isset($parent) && $type === 'facture') {
            // Pré-remplir avec les données du parent
            $document->fill($parent->toArray());
            $document->parent_id = $parent->id;
        }
        $view = 'back.dossiers.form';
        if (!$this->checkViewExists($view)) {
            $view = 'back.document.form';
            if (!$this->checkViewExists($view)) {
                abort(404, "Aucune vue trouvée pour le formulaire de document");
            }
        }
        return view('back.dossiers.form', compact('activity', 'society', 'type', 'document', 'parent'));
    }

    public function createFacture($activity, $society, $devisId)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        $devis = Document::where('id', $devisId)
            ->where('type', 'devis')
            ->firstOrFail();

        $lastFacture = Document::where('activity', $activity)
            ->where('society', $normalizedSociety)  // ← CORRIGER
            ->where('type', 'facture')
            ->latest()
            ->first();
        $numero = $this->generateNextNumber($activity, $society, 'facture', $lastFacture);

        return view('back.dossiers.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => 'facture',
            'parent' => $devis,
            'document' => null,
            'numero' => $numero,
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

        return view('back.dossiers.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => 'attestation_realisation',
            'parent' => $devis,
            'document' => null,
            'numero' => $numero,
        ]);
    }

    public function createAttestationSignataireFromDevis($activity, $society, Document $devis)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        $lastAttestation = Document::where('activity', $activity)
            ->where('society', $normalizedSociety)  // ← CORRIGER
            ->where('type', 'attestation_signataire')
            ->latest()
            ->first();


        $numero = $this->generateNextNumber($activity, $society, 'attestation_signataire', $lastAttestation);

        return view('back.dossiers.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => 'attestation_signataire',
            'parent' => $devis,
            'document' => null,
            'numero' => $numero,
        ]);
    }

    public function createCahierDesChargesFromDevis($activity, $society, Document $devis)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        $lastCahier = Document::where('activity', $activity)
            ->where('society', $normalizedSociety)  // ← CORRIGER
            ->where('type', 'cahier_des_charges')
            ->latest()
            ->first();

        $numero = $this->generateNextNumber($activity, $society, 'cahier_des_charges', $lastCahier);

        return view('back.dossiers.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => 'cahier_des_charges',
            'parent' => $devis,
            'document' => null,
            'numero' => $numero,
        ]);
    }

    public function createRapportFromFacture(string $activity, string $society, int $factureId)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        $facture = Document::findOrFail($factureId);

        $lastRapport = Document::where('activity', $activity)
            ->where('society', $normalizedSociety)  // ← CORRIGER
            ->where('type', 'rapport')
            ->latest()
            ->first();

        $numero = $this->generateNextNumber($activity, $society, 'rapport', $lastRapport);

        $document = new Document();
        $document->type = 'rapport';
        $document->society = $society;
        $document->activity = $activity;
        $document->parent_id = $facture->id;
        $document->numero = $numero;

        return view('back.dossiers.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => 'rapport',
            'parent' => $facture,
            'document' => $document,
        ]);
    }

    // =========================================================================
    // ENREGISTREMENT ET MISE À JOUR
    // =========================================================================

    public function store(Request $request, $activity, $society, $type)
    {
        // Normaliser la société
        $normalizedSociety = $this->normalizeSociety($society);

        Log::info('📝 STORE METHOD CALLED', [
            'activity' => $activity,
            'society' => $society,
            'normalized_society' => $normalizedSociety,
            'type' => $type,
            'user_id' => auth()->id(),
        ]);

        if (!$request->all()) {
            Log::error('⚠️ FORM IS EMPTY!');
            return back()->withErrors(['error' => 'Le formulaire est vide']);
        }

        return DB::transaction(function () use ($request, $activity, $society, $normalizedSociety, $type) {
            $data = $request->all();

            // Gérer l'upload du PDF - utiliser la société normalisée pour le chemin
            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                $path = $file->store("documents/{$normalizedSociety}/{$activity}/{$type}", 'public');
                $data['file_path'] = 'storage/' . $path;
                Log::info('📁 File uploaded', ['file_path' => $data['file_path']]);
            }

            // Si document a un parent
            if (in_array($type, ['facture', 'attestation_realisation', 'attestation_signataire', 'rapport']) && !empty($data['parent_id'])) {
                try {
                    $parent = Document::findOrFail($data['parent_id']);
                    $parentData = $parent->only($parent->getFillable());
                    foreach (['id', 'reference', 'type', 'file_path', 'created_at', 'updated_at'] as $exclude) {
                        unset($parentData[$exclude]);
                    }
                    $data = array_merge($parentData, $data);
                } catch (\Exception $e) {
                    Log::error('❌ Parent not found', ['parent_id' => $data['parent_id']]);
                }
            }

            // Champs obligatoires - utiliser la société normalisée
            $data['reference'] = $data['reference'] ?? Document::generateReference($normalizedSociety, $type);
            $data['society'] = $normalizedSociety;  // ← CORRECTION ICI
            $data['activity'] = $activity;
            $data['type'] = $type;
            $data['user_id'] = auth()->id();

            // Ajouter la numérotation personnalisée si présente
            if (!isset($data['numero']) && isset($data['numero_custom'])) {
                $data['numero'] = $data['numero_custom'];
            } elseif (!isset($data['numero'])) {
                $lastDocument = Document::where('activity', $activity)
                    ->where('society', $normalizedSociety)  // ← CORRECTION ICI
                    ->where('type', $type)
                    ->latest()
                    ->first();
                $data['numero'] = $this->generateNextNumber($activity, $normalizedSociety, $type, $lastDocument);
            }

            // Filtrer fillable
            $model = new Document();
            $filteredData = array_filter($data, fn($key) => in_array($key, $model->getFillable()), ARRAY_FILTER_USE_KEY);

            // Créer document
            $document = Document::create($filteredData);
            Log::info('✅ Document created', [
                'id' => $document->id,
                'society' => $document->society,
                'reference' => $document->reference
            ]);

            // Générer PDF dynamique
            try {
                $this->generatePdf($document);
            } catch (\Exception $pdfError) {
                Log::error('❌ PDF generation failed', ['error' => $pdfError->getMessage()]);
            }

            // Rediriger avec la société d'origine (pas normalisée) pour la route
            return redirect()
                ->route('back.document.show', [$activity, $society, $type, $document->id])
                ->with('success', 'Document créé avec succès!');
        });
    }


    public function update(Request $request, $activity, $society, $type, Document $document)
    {
        try {
            Log::info('📝 Update method called', ['document_id' => $document->id]);

            $formData = $request->all();

            // Si le document est lié, récupérer les données du document lié
            if (!empty($formData['linked_devis'])) {
                $linked = Document::where('reference', $formData['linked_devis'])->first();
                if ($linked) {
                    $linkedData = $linked->only($linked->getFillable());
                    $formData = array_merge($linkedData, $formData);
                }
            }

            if (!empty($formData['linked_facture'])) {
                $linked = Document::where('reference', $formData['linked_facture'])->first();
                if ($linked) {
                    $linkedData = $linked->only($linked->getFillable());
                    $formData = array_merge($linkedData, $formData);
                }
            }

            // Filtrer pour ne garder que les champs fillable
            $fillableFields = $document->getFillable();
            $filteredData = [];

            foreach ($fillableFields as $field) {
                if (isset($formData[$field])) {
                    $filteredData[$field] = $formData[$field];
                }
            }

            $document->update($filteredData);

            // Regénération PDF
            try {
                $this->generatePdf($document);
            } catch (\Exception $e) {
                Log::error('❌ PDF update error:', ['error' => $e->getMessage()]);
            }

            return back()->with('success', 'Document mis à jour avec succès');

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
    public function listDocuments($activity, $society, $type)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        // Si type = "all", on récupère tous les types
        if ($type === 'all') {
            $query = Document::where('activity', $activity)
                ->where('society', $normalizedSociety);  // ← CORRECTION: retirer "operator:"
        } else {
            $query = Document::where('activity', $activity)
                ->where('society', $normalizedSociety)  // ← CORRECTION: retirer "operator:"
                ->where('type', $type);
        }

        $documents = $query->with(['user', 'parent'])
            ->latest()
            ->paginate(20);

        // Statistiques - ADAPTÉES À VOTRE STRUCTURE DE TABLE
        if ($type === 'all') {
            $stats = [
                'total' => Document::where('activity', $activity)
                    ->where('society', $normalizedSociety)  // ← CORRECTION
                    ->count(),
                'devis' => Document::where('activity', $activity)
                    ->where('society', $normalizedSociety)  // ← CORRECTION
                    ->where('type', 'devis')
                    ->count(),
                'factures' => Document::where('activity', $activity)
                    ->where('society', $normalizedSociety)  // ← CORRECTION
                    ->where('type', 'facture')
                    ->count(),
                'rapports' => Document::where('activity', $activity)
                    ->where('society', $normalizedSociety)  // ← CORRECTION
                    ->where('type', 'rapport')
                    ->count(),
                'cahiers' => Document::where('activity', $activity)
                    ->where('society', $normalizedSociety)  // ← CORRECTION
                    ->where('type', 'cahier_des_charges')
                    ->count(),
                'attestations' => Document::where('activity', $activity)
                    ->where('society', $normalizedSociety)  // ← CORRECTION
                    ->whereIn('type', ['attestation_realisation', 'attestation_signataire'])
                    ->count(),
            ];
        } else {
            // Pour un type spécifique, simplifions sans 'statut'
            $stats = [
                'total' => Document::where('activity', $activity)  // ← CORRECTION: retirer "operator:"
                    ->where('society', $normalizedSociety)
                    ->where('type', $type)
                    ->count(),
                'ce_mois' => Document::where('activity', $activity)
                    ->where('society', $normalizedSociety)
                    ->where('type', $type)
                    ->whereMonth('created_at', now()->month)
                    ->count(),
                'cette_semaine' => Document::where('activity', $activity)
                    ->where('society', $normalizedSociety)
                    ->where('type', $type)
                    ->where('created_at', '>=', now()->subWeek())
                    ->count(),
            ];
        }

        return view('back.dossiers.list_documents', compact(
            'documents',
            'activity',
            'society',
            'type',
            'stats'
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
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        // Vérifier avec la société normalisée
        if ($document->activity !== $activity || $document->society !== $normalizedSociety || $document->type !== $type) {
            abort(404);
        }

        // Chemin du PDF généré
        $pdfPath = storage_path("app/public/pdf/{$document->society}/{$document->activity}/{$document->type}/{$document->reference}.pdf");

        // Si le PDF n'existe pas, le générer
        if (!file_exists($pdfPath)) {
            try {
                $this->generatePdf($document);
                $pdfPath = storage_path("app/public/pdf/{$document->society}/{$document->activity}/{$document->type}/{$document->reference}.pdf");
            } catch (\Exception $e) {
                Log::error('❌ PDF generation for download failed', [
                    'message' => $e->getMessage(),
                    'document_id' => $document->id
                ]);

                return back()->withErrors('Erreur lors de la génération du PDF: ' . $e->getMessage());
            }
        }

        // Télécharger le PDF
        return response()->download($pdfPath, "{$document->reference}.pdf");
    }

    public function preview($activity, $society, $type, Document $document)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        // Vérifier avec la société normalisée
        if ($document->activity !== $activity || $document->society !== $normalizedSociety || $document->type !== $type) {
            abort(404);
        }

        // Prévisualisation HTML du PDF
        $viewData = $this->preparePdfData($document);
        $view = $this->getPdfView($document);

        if (!view()->exists($view)) {
            abort(404, "Template PDF non trouvé: {$view}");
        }

        return view($view, $viewData);
    }

    public function edit($activity, $society, $type, Document $document)
    {
        // NORMALISER ICI
        $normalizedSociety = $this->normalizeSociety($society);

        // Vérifier avec la société normalisée
        if ($document->activity !== $activity || $document->society !== $normalizedSociety || $document->type !== $type) {
            abort(404);
        }

        return view('back.dossiers.form', [
            'activity' => $activity,
            'society' => $society,
            'type' => $type,
            'parent' => $document->parent,
            'document' => $document,
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
    public function download($activity, $society, $type, Document $document)
    {
        if (!$document->file_path || !Storage::disk('public')->exists(str_replace('storage/', '', $document->file_path))) {
            abort(404);
        }

        return Storage::disk('public')->download(
            str_replace('storage/', '', $document->file_path),
            $document->numero . '_' . Str::slug($document->client_nom) . '.' .
            pathinfo($document->file_path, PATHINFO_EXTENSION)
        );
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
     */
    private function generatePdf(Document $document): void
    {
        set_time_limit(120);

        try {
            Log::info('🔄 PDF GENERATION START', [
                'document_id' => $document->id,
                'type' => $document->type,
                'society' => $document->society,
                'activity' => $document->activity
            ]);

            // 1. Préparer les données
            $viewData = $this->preparePdfData($document);

            // 2. Déterminer la vue Blade selon votre structure
            $view = $this->getPdfView($document);

            // 3. Chemin de sortie
            $outputDir = storage_path("app/public/pdf/{$document->society}/{$document->activity}/{$document->type}");
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0775, true);
            }

            $outputPath = "{$outputDir}/{$document->reference}.pdf";
            $relativePath = "pdf/{$document->society}/{$document->activity}/{$document->type}/{$document->reference}.pdf";

            Log::info('📄 PDF generation details', [
                'view' => $view,
                'output_path' => $outputPath
            ]);

            // 4. Générer avec le service
            $this->pdfFillService->generate($view, $viewData, $outputPath);

            // 5. Mettre à jour la base de données
            $document->update([
                'file_path' => $relativePath,
            ]);

            Log::info('✅ PDF GENERATION SUCCESS', [
                'file_path' => $relativePath,
                'document_id' => $document->id
            ]);

        } catch (\Exception $e) {
            Log::error('❌ PDF generation failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'document_id' => $document->id
            ]);

            throw new \RuntimeException("Erreur génération PDF: " . $e->getMessage());
        }
    }

    /**
     * Retourne le chemin de la vue Blade pour le PDF
     */
private function getPdfView(Document $document): string
{
    // Mapping des noms de société pour les templates PDF
    $pdfSocietyMapping = [
        'energie_nova' => 'nova',    // Dans l'URL: energie_nova, template: nova
        'myhouse' => 'house',        // Dans l'URL: myhouse, template: house
        'nova' => 'nova',           // Compatibilité
        'house' => 'house'          // Compatibilité
    ];
    
    $templateSociety = $pdfSocietyMapping[$document->society] ?? $document->society;
    
    $view = "pdf.{$templateSociety}.{$document->activity}.{$document->type}";
    
    // Log pour debug
    Log::info('📄 PDF View Mapping', [
        'document_society' => $document->society,
        'template_society' => $templateSociety,
        'view' => $view,
        'view_exists' => view()->exists($view)
    ]);
    
    if (!view()->exists($view)) {
        // Liste toutes les vues disponibles pour debug
        $availableViews = [];
        $basePath = resource_path('views/pdf');
        
        foreach (['nova', 'house'] as $societyDir) {
            foreach (['desembouage', 'reequilibrage'] as $activityDir) {
                $typesPath = "{$basePath}/{$societyDir}/{$activityDir}";
                if (is_dir($typesPath)) {
                    $files = scandir($typesPath);
                    foreach ($files as $file) {
                        if (str_ends_with($file, '.blade.php')) {
                            $type = str_replace('.blade.php', '', $file);
                            $availableViews[] = "pdf.{$societyDir}.{$activityDir}.{$type}";
                        }
                    }
                }
            }
        }
        
        Log::error('❌ PDF template not found', [
            'requested_view' => $view,
            'available_views' => $availableViews
        ]);
        
        throw new \Exception("Template PDF non trouvé: {$view}. Disponibles: " . implode(', ', $availableViews));
    }
    
    return $view;
}
private function getAvailablePdfViews()
{
    $views = [];
    
    // Scanner les dossiers PDF
    $basePath = resource_path('views/pdf');
    
    foreach (['nova', 'house'] as $society) {
        foreach (['desembouage', 'reequilibrage'] as $activity) {
            $typesPath = "{$basePath}/{$society}/{$activity}";
            if (is_dir($typesPath)) {
                $files = scandir($typesPath);
                foreach ($files as $file) {
                    if (str_ends_with($file, '.blade.php')) {
                        $type = str_replace('.blade.php', '', $file);
                        $views[] = "pdf.{$society}.{$activity}.{$type}";
                    }
                }
            }
        }
    }
    
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

        if ($lastDocument && preg_match('/^' . $prefix . '-\d{4}-\d{2}-(\d+)$/', $lastDocument->numero, $matches)) {
            $nextNumber = str_pad((int) $matches[1] + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . '-' . $year . '-' . $month . '-' . $nextNumber;
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
                $rules['date_echeance'] = 'nullable|date|after_or_equal:date';
                $rules['mode_paiement'] = 'nullable|string|in:virement,cheque,carte,especes';
                break;

            case 'rapport':
                $rules['conclusion'] = 'nullable|string';
                $rules['recommandations'] = 'nullable|string';
                break;

            case 'attestation_realisation':
            case 'attestation_signataire':
                $rules['date_realisation'] = 'required|date';
                break;
        }

        // Pour la mise à jour, le numéro n'est pas obligatoire
        if ($update) {
            unset($rules['numero']);
        }

        return $rules;
    }
}