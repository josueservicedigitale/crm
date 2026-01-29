<?php

// namespace App\Services;

// use App\Models\Document;
// use Barryvdh\DomPDF\Facade\Pdf;
// use Illuminate\Support\Facades\Storage;

// class PdfFillService
// {

// public function generateAndSavePdf(Document $document, string $template)
// {
//     // 1️⃣ Préparer les données
//     $data = ['document' => $document];

//     // 2️⃣ Nom et chemin du PDF
//     $filename = $document->reference . '.pdf';
//     $folder = "documents/{$document->society}/{$document->activity}/{$document->type}";
//     $fullPath = $folder . '/' . $filename;

//     // 3️⃣ Créer les dossiers si inexistants
//     if (!Storage::disk('public')->exists($folder)) {
//         Storage::disk('public')->makeDirectory($folder, 0755, true);
//     }

//     // 4️⃣ Générer le PDF
//     $pdf = Pdf::loadView($template, $data)
//               ->setPaper('a4', 'portrait')
//               ->setOption('defaultFont', 'DejaVu Sans');

//     // 5️⃣ Sauvegarder sur disque public
//     Storage::disk('public')->put($fullPath, $pdf->output());

//     // 6️⃣ Mettre à jour le document en DB
//     $document->file_path = 'storage/' . $fullPath;
//     $document->pdf_generated_at = now();
//     $document->save();

//     return $document->file_path;
// }

// }


namespace App\Services;

use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PdfFillService
{
    public function generateAndSavePdf(Document $document, string $template)
    {
        try {
            // 1️⃣ Préparer TOUTES les données dynamiquement
            $data = $this->prepareDocumentData($document);

            // 2️⃣ Vérifier que le template existe
            if (!view()->exists($template)) {
                Log::error("Template PDF non trouvé : {$template}");
                throw new \Exception("Template PDF introuvable : {$template}");
            }

            // 3️⃣ Nom et chemin du PDF
            $filename = $document->reference . '_' . now()->format('Ymd_His') . '.pdf';
            $folder = "documents/{$document->society}/{$document->activity}/{$document->type}";
            $fullPath = $folder . '/' . $filename;

            // 4️⃣ Créer les dossiers
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder, 0755, true);
            }

            // 5️⃣ Générer le PDF avec TOUTES les données
            $pdf = Pdf::loadView($template, $data)
                ->setPaper('a4', 'portrait')
                ->setOption('defaultFont', 'DejaVu Sans')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true)
                ->setOption('chroot', public_path());

            // 6️⃣ Sauvegarder
            Storage::disk('public')->put($fullPath, $pdf->output());

            // Vérifier que le fichier est créé
            if (!Storage::disk('public')->exists($fullPath)) {
                throw new \Exception("Échec de la création du fichier PDF");
            }

            // 7️⃣ Mettre à jour le document
            $document->file_path = 'storage/' . $fullPath;
            $document->pdf_generated_at = now();
            $document->save();

            Log::info("PDF généré avec succès", [
                'document_id' => $document->id,
                'path' => $fullPath,
                'template' => $template,
                'data_fields' => array_keys($data['document_data'] ?? [])
            ]);

            return $document->file_path;

        } catch (\Exception $e) {
            Log::error("Erreur génération PDF", [
                'document_id' => $document->id,
                'template' => $template,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Préparer toutes les données du document de manière dynamique
     */
    private function prepareDocumentData(Document $document): array
    {
        // Récupérer toutes les colonnes du document
        $documentData = $document->toArray();

        // Ajouter les relations si elles existent
        if ($document->relationLoaded('user')) {
            $documentData['user'] = $document->user;
        }

        if ($document->relationLoaded('parent')) {
            $documentData['parent'] = $document->parent;
            // Fusionner les données du parent si nécessaire
            if ($document->parent) {
                $documentData = array_merge($document->parent->toArray(), $documentData);
            }
        }

        // Formater les données spécifiques
        $formattedData = $this->formatData($documentData);

        // Données supplémentaires utiles pour les templates
        $additionalData = [
            'today' => now()->format('d/m/Y'),
            'today_iso' => now()->format('Y-m-d'),
            'year' => now()->format('Y'),
            'month' => now()->format('m'),
            'society_name' => $this->getSocietyName($document->society),
            'activity_name' => $this->getActivityName($document->activity),
            'type_name' => $this->getTypeName($document->type),
        ];

        return [
            'document' => $document, // L'objet complet Document
            'data' => $formattedData, // Données formatées
            'raw' => $documentData,   // Données brutes
            'meta' => $additionalData,
            // Pour compatibilité, on garde aussi les données à la racine
            'reference' => $document->reference,
            'client_nom' => $documentData['client_nom'] ?? $documentData['nom_residence'] ?? '',
            'adresse_travaux' => $documentData['adresse_travaux'] ?? '',
            'montant_ttc' => $documentData['montant_ttc'] ?? 0,
            // Ajouter tous les champs dynamiquement
        ] + $formattedData; // Fusionner pour accès direct dans la vue
    }

    /**
     * Formater les données (dates, montants, etc.)
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
     * Helper pour les noms de société
     */
    private function getSocietyName(string $code): string
    {
        $societies = [
            'nova' => 'Énergie Nova',
            'energie_nova' => 'Énergie Nova',
            'house' => 'MyHouse Solutions',
            'myhouse' => 'MyHouse Solutions',
        ];

        return $societies[$code] ?? $code;
    }

    /**
     * Helper pour les noms d'activité
     */
    private function getActivityName(string $code): string
    {
        $activities = [
            'desembouage' => 'Désembouage',
            'reequilibrage' => 'Rééquilibrage',
        ];

        return $activities[$code] ?? $code;
    }

    /**
     * Helper pour les noms de type
     */
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

        return $types[$code] ?? $code;
    }
}