<?php

namespace App\Services;

use setasign\Fpdi\Tcpdf\Fpdi;
use RuntimeException;

class PdfFillService
{
    /**
     * Mapping fixe des templates
     */
    private array $templateMap = [
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

    /**
     * Génère un PDF à partir du template mappé
     */
    public function generate(string $activity, string $society, string $type, array $fields, string $outputPath): void
    {
        $key = "{$activity}.{$society}.{$type}";

        if (!isset($this->templateMap[$key])) {
            throw new RuntimeException("Template non trouvé pour {$key}");
        }

        $template = $this->templateMap[$key];
        $templatePath = storage_path("app/pdf-templates/{$template}");

        if (!file_exists($templatePath)) {
            throw new RuntimeException("Template PDF introuvable : {$templatePath}");
        }

        $this->ensureDirectoryExists($outputPath);

        $pdf = $this->initPdf();
        $pageCount = $pdf->setSourceFile($templatePath);

        for ($page = 1; $page <= $pageCount; $page++) {
            $tplId = $pdf->importPage($page);
            $size = $pdf->getTemplateSize($tplId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);

            foreach ($fields as $field) {
                if ((int)$field['page'] !== $page) continue;

                $pdf->SetFont('helvetica', !empty($field['bold']) ? 'B' : '', $field['size'] ?? 10);
                $rgb = $this->hexToRgb($field['color'] ?? 'black');
                $pdf->SetTextColor($rgb[0], $rgb[1], $rgb[2]);
                $pdf->Text($field['x'], $field['y'], (string)$field['value']);
            }
        }

        $pdf->Output($outputPath, 'F');
    }

    private function initPdf(): Fpdi
    {
        $pdf = new Fpdi('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetAutoPageBreak(false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        return $pdf;
    }

    private function ensureDirectoryExists(string $path): void
    {
        $dir = dirname($path);
        if (!is_dir($dir)) mkdir($dir, 0775, true);
    }

    private function hexToRgb(string $color): array
    {
        $colors = [
            'black'=>[0,0,0], 'white'=>[255,255,255], 'red'=>[255,0,0],
            'green'=>[0,128,0], 'blue'=>[0,0,255], 'darkblue'=>[0,0,139],
            'light_blue'=>[173,216,230]
        ];

        if (isset($colors[$color])) return $colors[$color];
        if (preg_match('/^#?([a-f0-9]{6})$/i', $color, $matches)) {
            return [hexdec(substr($matches[1],0,2)), hexdec(substr($matches[1],2,2)), hexdec(substr($matches[1],4,2))];
        }
        return [0,0,0];
    }
}
