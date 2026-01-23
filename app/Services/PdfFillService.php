<?php

namespace App\Services;
use Barryvdh\DomPDF\Facade\Pdf;
use RuntimeException;

class PdfFillService
{
    /**
     * Génère un PDF dynamique à partir d'une vue Blade et des données
     *
     * @param string $view       Le chemin de la vue Blade (ex: pdf.nova.desembouage.devis)
     * @param array  $data       Données à injecter dans la vue (ex: ['document' => $document])
     * @param string $outputPath Chemin complet où sauvegarder le PDF
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function generate(string $view, array $data, string $outputPath): void
    {
        if (!view()->exists($view)) {
            throw new RuntimeException("La vue Blade PDF n'existe pas : {$view}");
        }

        // Génération du PDF avec DomPDF
        $pdf = Pdf::loadView($view, $data)
                  ->setPaper('a4')
                  ->setOption('isRemoteEnabled', true); // pour charger images si besoin

        // Création du dossier si inexistant
        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        // Écriture du PDF final
        file_put_contents($outputPath, $pdf->output());
    }
}
