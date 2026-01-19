<?php


namespace App\Http\Controllers\Back;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\PdfFillService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DocumentController extends Controller
{
    protected PdfFillService $pdfFillService;
   
    public function __construct(PdfFillService $pdfFillService)
    {
        $this->pdfFillService = $pdfFillService;
    }

    public function dashboard($activity, $society)
    {
        $views = [
            'nova' => [
                'desembouage'   => 'back.dossiers.nova.novadesembouageboard',
                'reequilibrage' => 'back.dossiers.nova.novaboard',
            ],
            'house' => [
                'desembouage'   => 'back.dossiers.house.housedesembouageboard',
                'reequilibrage' => 'back.dossiers.house.houseboard',
            ],
        ];

        abort_if(!isset($views[$society][$activity]), 404);

        $recentDocuments = Document::where(compact('society', 'activity'))
            ->latest()
            ->take(5)
            ->get();

        return view($views[$society][$activity], compact('activity', 'society', 'recentDocuments'));
    }

    public function create($activity, $society, $type)
    {
        abort_if(
            in_array($type, ['facture', 'attestation_realisation', 'attestation_signataire']),
            404
        );

        return view('back.dossiers.form', [
            'activity' => $activity,
            'society'  => $society,
            'type'     => $type,
            'parent'   => null,
            'document' => null,
        ]);
    }


public function store(Request $request, $activity, $society, $type)
{
    Log::info('🔴 STORE METHOD CALLED', [
        'activity' => $activity,
        'society'  => $society,
        'type'     => $type,
        'user_id'  => auth()->id(),
    ]);

    if (!$request->all()) {
        Log::error('⚠️ FORM IS EMPTY!');
        return back()->withErrors(['error' => 'Le formulaire est vide']);
    }

    return DB::transaction(function () use ($request, $activity, $society, $type) {

        $data = $request->all();

        // 🔹 Gérer l'upload du PDF
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $path = $file->store("documents/{$society}/{$activity}/{$type}", 'public');
            $data['file_path'] = 'storage/' . $path;
            Log::info('📁 File uploaded', ['file_path' => $data['file_path']]);
        }

        // 🔹 Si document a un parent
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

        // Champs obligatoires
        $data['reference'] = $data['reference'] ?? Document::generateReference($society, $type);
        $data['society']   = $society;
        $data['activity']  = $activity;
        $data['type']      = $type;
        $data['user_id']   = auth()->id();

        // Filtrer fillable
        $model = new Document();
        $filteredData = array_filter($data, fn($key) => in_array($key, $model->getFillable()), ARRAY_FILTER_USE_KEY);

        // Créer document
        $document = Document::create($filteredData);
        Log::info('🎉 Document created', ['id' => $document->id, 'file_path' => $document->file_path]);

        // Générer PDF si nécessaire
        try {
            $this->generatePdf($document);
        } catch (\Exception $pdfError) {
            Log::error('PDF generation failed', ['error' => $pdfError->getMessage()]);
        }

        return redirect()
            ->route('back.document.show', [$activity, $society, $type, $document->id])
            ->with('success', 'Document créé avec succès!');
    });
}


    public function update(Request $request, $activity, $society, $type, Document $document)
    {
        try {
            Log::info('Update method called', ['document_id' => $document->id, 'data' => $request->all()]);
            
            $formData = $request->all();

            // 2️⃣ Si le document est lié, récupérer les données du document lié
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

            Log::info('Updating document with filtered data:', $filteredData);
            
            $document->update($filteredData);

            // 4️⃣ Regénération PDF
            try {
                $this->generatePdf($document);
            } catch (\Exception $e) {
                Log::error('PDF update error:', ['error' => $e->getMessage()]);
            }

            return back()->with('success', 'Document mis à jour avec succès');

        } catch (\Exception $e) {
            Log::error('UPDATE DOCUMENT ERROR', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return back()->withErrors('Erreur lors de la mise à jour du document: ' . $e->getMessage());
        }
    }

    public function createFacture($activity, $society, $devisId)
    {
        // Récupère le devis choisi
        $devis = Document::where('id', $devisId)
                         ->where('type', 'devis')
                         ->firstOrFail();

        // On prépare un "document vide" pour le formulaire facture
        $document = null;

        return view('back.dossiers.form', [
            'activity' => $activity,
            'society'  => $society,
            'type'     => 'facture',
            'parent'   => $devis, // le devis choisi
            'document' => $document,
        ]);
    }

    public function selectDevisForAttestation($activity, $society)
    {
        $devisList = Document::where([
            'activity' => $activity,
            'society'  => $society,
            'type'     => 'devis',
        ])->latest()->get();

        return view('back.dossiers.select_devis_attestation', compact(
            'devisList',
            'activity',
            'society'
        ));
    }

    public function createAttestationFromDevis(
        $activity,
        $society,
        Document $devis
    ) {
        if ($devis->type !== 'devis') {
            abort(404);
        }

        return view('back.dossiers.form', [
            'activity' => $activity,
            'society'  => $society,
            'type'     => 'attestation_realisation',
            'parent'   => $devis,
            'document' => null,
        ]);
    }

    // 🔹 NOUVELLE MÉTHODE POUR ATTESTATION SIGNATAIRE
    public function createAttestationSignataireFromDevis(
        $activity,
        $society,
        Document $devis
    ) {
        if ($devis->type !== 'devis') {
            abort(404);
        }

        return view('back.dossiers.form', [
            'activity' => $activity,
            'society'  => $society,
            'type'     => 'attestation_signataire',
            'parent'   => $devis,
            'document' => null,
        ]);
    }
  
private function generatePdf(Document $document): void
{
    
    set_time_limit(120);

    try {
        Log::info('=== PDF GENERATION START ===');

        /** @var PdfFillService $pdfService */
        $pdfService = app(PdfFillService::class);

        // 🔹 Mapping fixe des templates
        $templateMap = [
            // Désembouage Nova
            'desembouage.nova.devis' => 'denovadevis.pdf',
            'desembouage.nova.facture' => 'denovafacture.pdf',
            'desembouage.nova.attestation_realisation' => 'denovaattestation_realisation.pdf',
            'desembouage.nova.attestation_signataire' => 'denovaattestation_signataire.pdf',
            'desembouage.nova.cahier_des_charges' => 'denovacahier_des_charges.pdf',
            'desembouage.nova.rapport' => 'denovarapport.pdf',

            // Désembouage House
            'desembouage.house.devis' => 'dehousedevis.pdf',
            'desembouage.house.facture' => 'dehousefacture.pdf',
            'desembouage.house.attestation_realisation' => 'dehouseattestation_realisation.pdf',
            'desembouage.house.attestation_signataire' => 'dehouseattestation_signataire.pdf',
            'desembouage.house.cahier_des_charges' => 'dehousecahier_des_charges.pdf',
            'desembouage.house.rapport' => 'dehouserapport.pdf',

            // Rééquilibrage Nova
            'reequilibrage.nova.devis' => 'renovadevis.pdf',
            'reequilibrage.nova.facture' => 'renovafacture.pdf',
            'reequilibrage.nova.attestation_realisation' => 'renovaattestation_realisation.pdf',
            'reequilibrage.nova.attestation_signataire' => 'renovaattestation_signataire.pdf',
            'reequilibrage.nova.cahier_des_charges' => 'renovacahier_des_charges.pdf',
            'reequilibrage.nova.rapport' => 'renovarapport.pdf',

            // Rééquilibrage House
            'reequilibrage.house.devis' => 'rehousedevis.pdf',
            'reequilibrage.house.facture' => 'rehousefacture.pdf',
            'reequilibrage.house.attestation_realisation' => 'rehouseattestation_realisation.pdf',
            'reequilibrage.house.attestation_signataire' => 'rehouseattestation_signataire.pdf',
            'reequilibrage.house.cahier_des_charges' => 'rehousecahier_des_charges.pdf',
            'reequilibrage.house.rapport' => 'rehouserapport.pdf',
        ];

        $key = "{$document->activity}.{$document->society}.{$document->type}";
        if (!isset($templateMap[$key])) {
            throw new \RuntimeException("Template non trouvé pour {$key}");
        }

        $template = $templateMap[$key];
        $templatePath = storage_path("app/pdf-templates/{$template}");

        if (!file_exists($templatePath)) {
            throw new \RuntimeException("Template PDF introuvable : {$templatePath}");
        }

        $outputDir = storage_path("app/public/pdf/{$document->society}/{$document->activity}/{$document->type}");
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        $outputPath = "{$outputDir}/{$document->reference}.pdf";

        $fields = $this->mapFields($document);

$pdfService->generate(
    (string)$document->activity,
    (string)$document->society,
    (string)$document->type,
    $fields,
    $outputPath
);


        // 🔹 Enregistrement correct en DB (chemin relatif)
        $document->update([
            'file_path' => "pdf/{$document->society}/{$document->activity}/{$document->type}/{$document->reference}.pdf",
        ]);

        Log::info('=== PDF GENERATION SUCCESS ===', ['file_path' => $document->file_path]);

    } catch (\Exception $e) {
        Log::error('PDF generation failed', [
            'message' => $e->getMessage(),
            'trace'   => $e->getTraceAsString(),
            'document_id' => $document->id,
        ]);
    }
}


    public function selectDevis($activity, $society, $type)
    {
        abort_if(!in_array($type, [
            'facture',
            'attestation_realisation',
            'attestation_signataire',
            'cahier_des_charges'
        ]), 404);

        $devisList = Document::where([
            'activity' => $activity,
            'society'  => $society,
            'type'     => 'devis',
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

            public function selectDevisForSignataire($activity, $society)
        {
            $devisList = Document::where([
                'activity' => $activity,
                'society'  => $society,
                'type'     => 'devis',
            ])->latest()->get();

            return view('back.dossiers.select_devis_attestation_signataire', compact(
                'devisList',
                'activity',
                'society'
            ));
        }

        // 🔹 Sélection des devis pour cahier des charges
public function selectDevisForCahier($activity, $society)
{
    // Récupérer tous les devis pour cette société et activité
    $devisList = Document::where([
        'activity' => $activity,
        'society'  => $society,
        'type'     => 'devis',
    ])->latest()->get();

    // Retourner la vue spécifique de sélection pour le cahier des charges
    return view('back.dossiers.select_devis_cahier', compact(
        'devisList',
        'activity',
        'society'
    ));
}


        public function createCahierDesChargesFromDevis($activity, $society, Document $devis)
        {
            if ($devis->type !== 'devis') {
                abort(404);
            }

            return view('back.dossiers.form', [
                'activity' => $activity,
                'society'  => $society,
                'type'     => 'cahier_des_charges',
                'parent'   => $devis,
                'document' => null,
            ]);
        }



   private function mapFields(Document $document): array
        {
            $pageHeight = 842;

            $map =  [
                    'devis' => [
                        1 => [
                            'reference_devis' => [216, 733, 12, true],
                            'date_devis' => [139, 718, 12, true],
                            'adresse_travaux' => [105, 505, 8],
                            'numero_immatriculation' => [205, 495.5, 8],
                            'nom_residence' => [266, 495.5, 8],
                            'zone_climatique' => [107, 485.5, 8],
                            'parcelle_1' => [54, 462, 8],
                            'parcelle_2' => [190, 462, 8],
                            'parcelle_3' => [54, 449, 8],
                            'parcelle_4' => [190, 449, 8],
                            'dates_previsionnelles' => [174, 428, 7],
                            'nombre_batiments' => [124, 400, 8],
                            'details_batiments' => [72, 391, 8],
                            'prime_cee' => [410, 348, 7],
                        ],
                        2 => [
                            'reference_devis' => [216, 733, 12, true],
                            'date_devis' => [139, 718, 12, true],
                            'puissance_chaudiere' => [198, 632, 8],
                            'zone_climatique' => [135, 579.5, 8],
                            'nombre_logements' => [189, 622, 8],
                            'nombre_emetteurs' => [195, 611, 8],
                            'volume_circuit' => [179, 590, 8],
                            'nombre_filtres' => [102, 569, 8],
                            'wh_cumac' => [127, 548, 8],
                            'montant_ht' => [120, 537.5, 8],
                        ],
                        4 => [
                            'montant_tva' => [526, 371, 8, true],
                            'montant_ttc' => [526, 361, 8, true],
                            'reste_a_charge' => [526, 315, 8, true],
                            'somme' => [78, 277.5, 7],
                        ]
                    ],

                    'facture' => [
                        1 => [
                            'reference_devis' => [214, 733.2, 12, true],
                            'date_facture' => [139, 718, 12, true],
                            'adresse_travaux' => [105, 505, 8],
                            'numero_immatriculation' => [205, 495.5, 8],
                            'nom_residence' => [268, 495.5, 8],
                        ],
                        4 => [
                            'montant_ttc' => [522, 361, 8, true],
                            'montant_tva' => [522, 371, 8, true],
                            'reste_a_charge' => [522, 315, 8, true],
                        ]
                    ],

                    'attestation_realisation' => [
                        1 => [
                            'nombre_logements' => [186, 419, 8],
                            'adresse_travaux' => [186, 447, 8],
                            'puissance_chaudiere' => [186, 395, 8],
                            'volume_circuit' => [186, 364, 8],
                        ],
                        2 => [
                            'reference_devis' => [224, 469, 8, true],
                            'date_devis' => [248, 469, 8, true],
                        ]
                    ],

                    // 🔹 AJOUT DE LA CONFIGURATION POUR ATTESTATION SIGNATAIRE
                    'attestation_signataire' => [
                        1 => [
                            'nombre_logements' => [186, 419, 8],
                            'adresse_travaux' => [186, 447, 8],
                            'puissance_chaudiere' => [186, 395, 8],
                            'volume_circuit' => [186, 364, 8],
                        ],
                        2 => [
                            'reference_devis' => [224, 469, 8, true],
                            'date_devis' => [248, 469, 8, true],
                        ]
                    ],

                    'rapport' => [
                        1 => [
                            'adresse_travaux_1' => [9, 740, 7],
                            'boite_postale_1' => [9, 710, 7],
                            'puissance_chaudiere' => [245, 401, 9],
                            'nombre_emetteurs' => [375, 510, 9],
                            'volume_circuit' => [367, 402, 9],
                            'date_facture' => [412, 728, 8],
                            'reference_devis' => [463, 707.5, 8],
                        ]
                    ],
                ];
        $fields = [];

            foreach ($map[$document->type] ?? [] as $page => $items) {
                foreach ($items as $key => $item) {

                    $value = $this->resolveFieldValue($document, $key);

                    if ($value === null || $value === '') {
                        continue;
                    }

                    $fields[] = [
                        'page'  => $page,
                        'x'     => $item[0],
                        'y'     => $pageHeight - $item[1],
                        'size'  => $item[2],
                        'bold'  => $item[3] ?? false,
                        'color' => $item[4] ?? 'black',
                        'value' => $value,
                    ];
                }
            }

            return $fields;
        }





    public function listDocuments($activity, $society, $type)
        {
            $documents = Document::where(compact('activity', 'society', 'type'))->get();

            return view('back.dossiers.list', compact('documents', 'activity', 'society', 'type'));
        }

        public function chooseAction($activity, $society, $type)
            {
                return view('back.dossiers.choose_action', compact('activity', 'society', 'type'));
            }

        public function show($activity, $society, $type, Document $document)
            {
                $pdfDir  = storage_path('app/generated-pdfs');
                $pdfPath = "{$pdfDir}/{$type}-{$document->id}.pdf";

                if (!is_dir($pdfDir)) {
                    mkdir($pdfDir, 0775, true);
                }

                try {
                    if (!file_exists($pdfPath)) {
                        $fields = $this->mapFields($document);
                        $templateFile = "{$type}.pdf";

                        $pdfService = $this->pdfFillService ?? app(PdfFillService::class);
                    $pdfService = $this->pdfFillService ?? app(PdfFillService::class);

                    $pdfService->generate(
                        $document->activity,
                        $document->society,
                        $document->type,
                        $fields,
                        $pdfPath
                    );

                    }

                    // Force le téléchargement
                    return response()->download($pdfPath, "{$document->reference}.pdf");

                } catch (\Exception $e) {
                    Log::error('PDF download error', [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'document_id' => $document->id
                    ]);
                    
                    return back()->withErrors('Erreur lors du téléchargement du PDF: ' . $e->getMessage());
                }
            }

        public function createRapportFromFacture(string $activity, string $society, int $factureId)
            {
                $facture = Document::findOrFail($factureId);

                // Nouveau document “rapport” avec parent_id = facture
                $document = new Document();
                $document->type      = 'rapport';
                $document->society   = $society;
                $document->activity  = $activity;
                $document->parent_id = $facture->id;  // ← lien vers la facture

                return view('back.dossiers.form', [
                    'activity' => $activity,
                    'society'  => $society,
                    'type'     => 'rapport',
                    'parent'   => $facture,  
                    'document' => $document,
                ]);
            }




        public function selectDevisForFacture($activity, $society)
            {
                $devisList = Document::where([
                    'activity' => $activity,
                    'society'  => $society,
                    'type'     => 'devis'
                ])->latest()->get();

                return view('back.dossiers.select_devis', compact('activity', 'society', 'devisList'));
            }



            public function selectFactureForRapport(string $activity, string $society)
                {
                    
                    $factures = Document::where('society', $society)
                                        ->where('activity', $activity)
                                        ->where('type', 'facture')
                                        ->orderByDesc('created_at')
                                        ->get();

                    return view('back.dossiers.select_facture_for_rapport', [
                        'activity'    => $activity,
                        'society'     => $society,
                        'factures'    => $factures,
                        'type'        => 'rapport', 
                    ]);
                }


        private function resolveFieldValue(Document $document, string $key): ?string
            {
                
                if (!empty($document->$key)) {
                    return (string) $document->$key;
                }

                // 2️⃣ Parent (devis ou facture)
                if ($document->parent && !empty($document->parent->$key)) {
                    return (string) $document->parent->$key;
                }

                // 3️⃣ Parent du parent (rapport → facture → devis)
                if ($document->parent && $document->parent->parent && !empty($document->parent->parent->$key)) {
                    return (string) $document->parent->parent->$key;
                }
                if (str_starts_with($key, 'date_')) {
                return \Carbon\Carbon::parse($value)->format('d/m/Y');
                }


                return null;
            }

        private function drawGrid($pdf, int $step = 10)
            {
                $width  = $pdf->getPageWidth();
                $height = $pdf->getPageHeight();

                for ($x = 0; $x <= $width; $x += $step) {
                    $pdf->Line($x, 0, $x, $height);
                    $pdf->Text($x + 1, 2, (string)$x);
                }

                for ($y = 0; $y <= $height; $y += $step) {
                    $pdf->Line(0, $y, $width, $y);
                    $pdf->Text(1, $y + 1, (string)$y);
                }
            }



}