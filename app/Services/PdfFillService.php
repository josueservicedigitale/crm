<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Societe;
use App\Models\Activite;
use App\Models\Dossier;
use App\Models\Fichier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PdfFillService
{
    /**
     * Génère un PDF, le sauvegarde et l'ajoute aux dossiers de l'utilisateur
     */
  public function generateAndSavePdf(Document $document, string $template)
{
    try {
        Log::info('🚀 DÉBUT génération PDF', [
            'document_id' => $document->id,
            'template_demandé' => $template,
            'user_id' => Auth::id()
        ]);
        
        // 1️⃣ Vérifier que le template existe
        if (!view()->exists($template)) {
            Log::warning("⚠️ Template inexistant, recherche d'un fallback", [
                'template' => $template,
                'societe' => $document->society,
                'activite' => $document->activity,
                'type' => $document->type
            ]);
            
            // 🔥 Appel de la fonction de fallback
            $fallback = $this->findFallbackTemplate($document);
            
            if ($fallback) {
                Log::info('✅ Fallback trouvé', ['fallback' => $fallback]);
                $template = $fallback;
            } else {
                Log::error("❌ Aucun fallback trouvé");
                throw new \Exception("Template non trouvé et aucun fallback disponible: {$template}");
            }
        }
        
        Log::info('✅ Template utilisé', ['template' => $template]);
        
        // 2️⃣ Préparer les données
        $data = $this->prepareDocumentData($document);
        Log::info('✅ Données préparées', ['keys' => array_keys($data)]);
        
        // 3️⃣ Générer le PDF
        $pdf = Pdf::loadView($template, $data)
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'DejaVu Sans')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);
        
        Log::info('✅ PDF généré en mémoire');
        
        // 4️⃣ Sauvegarder le PDF
        $filename = $this->generateFilename($document);
        $folder = $this->generateFolderPath($document);
        $fullPath = $folder . '/' . $filename;
        
        Storage::disk('public')->makeDirectory($folder, 0755, true);
        Storage::disk('public')->put($fullPath, $pdf->output());
        
        Log::info('✅ PDF sauvegardé', [
            'path' => $fullPath,
            'size' => Storage::disk('public')->size($fullPath)
        ]);
        
        // 5️⃣ Mettre à jour le document
        $document->file_path = 'storage/' . $fullPath;
        $document->pdf_generated_at = now();
        $document->save();
        
        // 6️⃣ Ajouter aux dossiers (optionnel, ne bloque pas)
        try {
            $this->ajouterAuxDossiersUtilisateur($document, $fullPath);
        } catch (\Exception $e) {
            Log::error('❌ Erreur ajout aux dossiers (non bloquante)', [
                'error' => $e->getMessage(),
                'document_id' => $document->id
            ]);
        }
        
        return $document->file_path;
        
    } catch (\Exception $e) {
        Log::error('❌ ERREUR génération PDF', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        throw $e;
    }
}
    /**
     * ✅ NOUVEAU : Ajouter le PDF aux dossiers de l'utilisateur
     */
    private function ajouterAuxDossiersUtilisateur(Document $document, string $pdfPath)
    {
        $userId = Auth::id();
        if (!$userId) {
            Log::warning('⚠️ Utilisateur non connecté, impossible d\'ajouter aux dossiers');
            return;
        }

        try {
            // 1️⃣ Créer ou récupérer le dossier racine "Mes PDF générés"
            $dossierRacine = Dossier::firstOrCreate(
                [
                    'user_id' => $userId,
                    'nom' => 'Mes PDF générés',
                    'parent_id' => null,
                ],
                [
                    'slug' => 'mes-pdf-generes-' . $userId . '-' . uniqid(),
                    'description' => 'Tous vos PDF générés automatiquement',
                    'couleur' => '#0d6efd',
                    'icon' => 'fa-file-pdf',
                    'est_visible' => false, // Privé par défaut
                ]
            );

            // 2️⃣ Créer ou récupérer le sous-dossier par société
            $societe = Societe::where('code', $document->society)->first();
            $nomSociete = $societe ? ($societe->nom_formate ?? $societe->nom) : $document->society;
            
            $dossierSociete = Dossier::firstOrCreate(
                [
                    'user_id' => $userId,
                    'nom' => $nomSociete,
                    'parent_id' => $dossierRacine->id,
                ],
                [
                    'slug' => Str::slug($nomSociete) . '-' . uniqid(),
                    'societe_id' => $societe?->id,
                    'couleur' => $societe?->couleur ?? '#0d6efd',
                    'icon' => $societe?->icon ?? 'fa-building',
                    'est_visible' => false,
                ]
            );

            // 3️⃣ Créer ou récupérer le sous-dossier par activité
            $activite = Activite::where('code', $document->activity)->first();
            $nomActivite = $activite ? ($activite->nom_formate ?? $activite->nom) : $document->activity;
            
            $dossierActivite = Dossier::firstOrCreate(
                [
                    'user_id' => $userId,
                    'nom' => $nomActivite,
                    'parent_id' => $dossierSociete->id,
                ],
                [
                    'slug' => Str::slug($nomActivite) . '-' . uniqid(),
                    'activite_id' => $activite?->id,
                    'couleur' => $activite?->couleur ?? '#ffc107',
                    'icon' => $activite?->icon ?? 'fa-tasks',
                    'est_visible' => false,
                ]
            );

            // 4️⃣ Créer ou récupérer le sous-dossier par type de document
            $typeName = $this->getTypeName($document->type);
            
            $dossierType = Dossier::firstOrCreate(
                [
                    'user_id' => $userId,
                    'nom' => $typeName,
                    'parent_id' => $dossierActivite->id,
                ],
                [
                    'slug' => Str::slug($typeName) . '-' . uniqid(),
                    'couleur' => $this->getTypeColor($document->type),
                    'icon' => $this->getTypeIcon($document->type),
                    'est_visible' => false,
                ]
            );

            // 5️⃣ Enregistrer le fichier dans le dossier
            $fichier = Fichier::create([
                'nom' => basename($pdfPath),
                'nom_original' => $document->reference . '.pdf',
                'extension' => 'pdf',
                'mime_type' => 'application/pdf',
                'taille' => Storage::disk('public')->size($pdfPath),
                'chemin' => $pdfPath,
                'url' => Storage::url($pdfPath),
                'dossier_id' => $dossierType->id,
                'user_id' => $userId,
                'document_id' => $document->id,
                'est_visible' => $dossierType->est_visible, // Hérite de la visibilité du dossier
            ]);

            // 6️⃣ Mettre à jour les statistiques des dossiers
            foreach ([$dossierType, $dossierActivite, $dossierSociete, $dossierRacine] as $dossier) {
                $dossier->mettreAJourStats();
            }

            Log::info('✅ PDF ajouté aux dossiers', [
                'fichier_id' => $fichier->id,
                'dossier_id' => $dossierType->id,
                'chemin' => $dossierType->chemin_complet
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Erreur ajout aux dossiers', [
                'error' => $e->getMessage(),
                'document_id' => $document->id
            ]);
        }
    }

    /**
     * 🎯 Préparer toutes les données du document de manière dynamique
     */
    public function prepareDocumentData(Document $document): array
    {
        // Récupérer toutes les colonnes du document
        $documentData = $document->toArray();

        // ✅ CHARGER LES RELATIONS SI NÉCESSAIRE
        if (!$document->relationLoaded('user')) {
            $document->load('user');
        }
        if (!$document->relationLoaded('parent')) {
            $document->load('parent');
        }

        // Ajouter les relations
        if ($document->user) {
            $documentData['user'] = $document->user->toArray();
        }

        if ($document->parent) {
            $documentData['parent'] = $document->parent->toArray();
            // Fusionner les données du parent (sans écraser)
            foreach ($document->parent->toArray() as $key => $value) {
                if (!isset($documentData[$key]) || empty($documentData[$key])) {
                    $documentData[$key] = $value;
                }
            }
        }

        // ✅ RÉCUPÉRER LES INFOS DE LA SOCIÉTÉ DEPUIS LA BDD
        $societe = Societe::where('code', $document->society)->first();
        $documentData['societe'] = $societe ? $societe->toArray() : null;
        
        // ✅ RÉCUPÉRER LES INFOS DE L'ACTIVITÉ DEPUIS LA BDD
        $activite = Activite::where('code', $document->activity)->first();
        $documentData['activite'] = $activite ? $activite->toArray() : null;

        // Formater les données spécifiques
        $formattedData = $this->formatData($documentData);

        // Données supplémentaires avec infos BDD
        $additionalData = [
            'today' => now()->format('d/m/Y'),
            'today_iso' => now()->format('Y-m-d'),
            'year' => now()->format('Y'),
            'month' => now()->format('m'),
            'society_name' => $this->getSocietyNameFromDB($document->society, $societe),
            'society_color' => $societe->couleur ?? '#0d6efd',
            'society_icon' => $societe->icon ?? 'fa-building',
            'activity_name' => $this->getActivityNameFromDB($document->activity, $activite),
            'type_name' => $this->getTypeName($document->type),
            'type_color' => $this->getTypeColor($document->type),
            'type_icon' => $this->getTypeIcon($document->type),
        ];

        return [
            'document' => $document, // L'objet complet Document
            'data' => $formattedData, // Données formatées
            'raw' => $documentData,   // Données brutes
            'meta' => $additionalData,
            'societe' => $societe,    // Modèle société complet
            'activite' => $activite,   // Modèle activité complet
            // Pour compatibilité, on garde aussi les données à la racine
            'reference' => $document->reference,
            'client_nom' => $documentData['client_nom'] ?? $documentData['nom_residence'] ?? '',
            'adresse_travaux' => $documentData['adresse_travaux'] ?? '',
            'montant_ttc' => $documentData['montant_ttc'] ?? 0,
        ] + $formattedData;
    }

    /**
     * 🔍 Trouver un template de secours
     */
   private function findFallbackTemplate(Document $document): ?string
{
    $societe = Societe::where('code', $document->society)->first();
    $folder = $societe?->template_pdf_folder ?? $document->society;

    // Liste élargie des tentatives
    $attempts = [
        // 1. Template spécifique
        "pdf.{$folder}.{$document->activity}.{$document->type}",
        
        // 2. Template société + activité avec fallback "default" pour le type
        "pdf.{$folder}.{$document->activity}.default",
        
        // 3. Template société avec fallback "default" pour activité et type
        "pdf.{$folder}.default.default",
        
        // 4. Template global avec activité et type
        "pdf.default.{$document->activity}.{$document->type}",
        
        // 5. Template global avec activité seulement
        "pdf.default.{$document->activity}.default",
        
        // 6. Template global avec type seulement
        "pdf.default.default.{$document->type}",
        
        // 7. Template ultime
        "pdf.default.default.document",
    ];

    foreach ($attempts as $attempt) {
        if (view()->exists($attempt)) {
            Log::info('✅ Template fallback trouvé', [
                'original' => "pdf.{$folder}.{$document->activity}.{$document->type}",
                'fallback' => $attempt
            ]);
            return $attempt;
        }
    }

    Log::error('❌ Aucun template trouvé', [
        'societe' => $document->society,
        'activite' => $document->activity,
        'type' => $document->type
    ]);

    return null;
}

    /**
     * 📁 Générer un nom de fichier unique
     */
    private function generateFilename(Document $document): string
    {
        $prefix = strtoupper($document->type);
        $reference = $document->reference ?? $document->numero ?? $document->id;
        $date = now()->format('Ymd_His');
        $random = substr(md5(uniqid()), 0, 6);
        
        // Nettoyer la référence pour éviter les problèmes de fichiers
        $reference = preg_replace('/[^a-zA-Z0-9_-]/', '_', $reference);
        
        return "{$prefix}_{$reference}_{$date}_{$random}.pdf";
    }

    /**
     * 📁 Générer le chemin de dossier
     */
    private function generateFolderPath(Document $document): string
    {
        $societe = Societe::where('code', $document->society)->first();
        $folder = $societe?->template_pdf_folder ?? $document->society;

        $activity = $document->activity;
        $type = $document->type;
        $year = now()->format('Y');
        $month = now()->format('m');

        return "documents/{$folder}/{$activity}/{$type}/{$year}/{$month}";
    }

    /**
     * 📝 Formater les données
     */
    private function formatData(array $data): array
    {
        $formatted = [];

        foreach ($data as $key => $value) {
            $formatted[$key] = $value;

            // Formater les dates
            if (str_contains($key, 'date') || str_contains($key, 'created') || str_contains($key, 'updated')) {
                if ($value && !empty($value)) {
                    try {
                        $formatted[$key . '_formatted'] = \Carbon\Carbon::parse($value)->format('d/m/Y');
                        $formatted[$key . '_iso'] = \Carbon\Carbon::parse($value)->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Ignorer si pas une date valide
                    }
                }
            }

            // Formater les montants
            if (
                str_contains($key, 'montant') ||
                str_contains($key, 'prix') ||
                str_contains($key, 'total') ||
                str_contains($key, 'tva') ||
                str_contains($key, 'ht') ||
                str_contains($key, 'ttc') ||
                str_contains($key, 'prime') ||
                str_contains($key, 'reste')
            ) {
                if (is_numeric($value)) {
                    $formatted[$key . '_formatted'] = number_format(floatval($value), 2, ',', ' ') . ' €';
                    $formatted[$key . '_euros'] = number_format(floatval($value), 2, ',', ' ');
                }
            }

            // Formater les booléens
            if (is_bool($value)) {
                $formatted[$key . '_text'] = $value ? 'Oui' : 'Non';
            }
        }

        // Calculs supplémentaires
        if (isset($data['montant_ht']) && !isset($data['montant_ttc'])) {
            $tva = $data['tva'] ?? 20;
            $montantTTC = $data['montant_ht'] * (1 + $tva / 100);
            $formatted['montant_ttc_calcule'] = $montantTTC;
            $formatted['montant_ttc_calcule_formatted'] = number_format($montantTTC, 2, ',', ' ') . ' €';
        }

        return $formatted;
    }

    /**
     * 🏢 Nom de société depuis la BDD
     */
    private function getSocietyNameFromDB(string $code, ?Societe $societe): string
    {
        if ($societe) {
            return $societe->nom_formate;
        }
        
        // Fallback sur le mapping existant
        return $this->getSocietyName($code);
    }

    /**
     * 🎯 Nom d'activité depuis la BDD
     */
    private function getActivityNameFromDB(string $code, ?Activite $activite): string
    {
        if ($activite) {
            return $activite->nom_formate ?? $activite->nom;
        }
        
        // Fallback sur le mapping existant
        return $this->getActivityName($code);
    }

    /**
     * 🎨 Couleur par type de document
     */
    private function getTypeColor(string $type): string
    {
        return match($type) {
            'devis' => '#0d6efd',
            'facture' => '#198754',
            'rapport' => '#0dcaf0',
            'cahier_des_charges' => '#6c757d',
            'attestation_realisation' => '#ffc107',
            'attestation_signataire' => '#fd7e14',
            default => '#6c757d'
        };
    }

    /**
     * 📄 Icône par type de document
     */
    private function getTypeIcon(string $type): string
    {
        return match($type) {
            'devis' => 'fa-file-invoice',
            'facture' => 'fa-file-invoice-dollar',
            'rapport' => 'fa-chart-line',
            'cahier_des_charges' => 'fa-book',
            'attestation_realisation' => 'fa-check-circle',
            'attestation_signataire' => 'fa-user-check',
            default => 'fa-file'
        };
    }

    private function getSocietyName(string $code): string
    {
        $societies = [
            'nova' => 'Énergie Nova',
            'energie_nova' => 'Énergie Nova',
            'house' => 'MyHouse Solutions',
            'myhouse' => 'MyHouse Solutions',
            'patrimoine' => 'Patrimoine Immobilier',
            'patrimoine_immobilier' => 'Patrimoine Immobilier',
        ];

        return $societies[$code] ?? ucfirst(str_replace('_', ' ', $code));
    }

    private function getActivityName(string $code): string
    {
        $activities = [
            'desembouage' => 'Désembouage',
            'reequilibrage' => 'Rééquilibrage',
        ];

        return $activities[$code] ?? ucfirst(str_replace('_', ' ', $code));
    }

    private function getTypeName(string $code): string
    {
        $types = [
            'devis' => 'Devis',
            'facture' => 'Facture',
            'rapport' => 'Rapport',
            'cahier_des_charges' => 'Cahier des Charges',
            'attestation_realisation' => 'Attestation de Réalisation',
            'attestation_signataire' => 'Attestation Signataire',
        ];

        return $types[$code] ?? ucfirst(str_replace('_', ' ', $code));
    }
}