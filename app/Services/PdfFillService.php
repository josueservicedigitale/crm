<?php

namespace App\Services;
use Barryvdh\DomPDF\Facade\Pdf;
use RuntimeException;
use Illuminate\Support\Facades\Log;
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
    Log::info('🔄 PDF SERVICE CALLED', [
        'view' => $view,
        'data_keys' => array_keys($data),
        'output_path' => $outputPath
    ]);

    if (!view()->exists($view)) {
        $error = "La vue Blade PDF n'existe pas : {$view}";
        Log::error('❌ PDF VIEW NOT FOUND', [
            'view' => $view,
            'available_views_in_path' => $this->getViewsInPath($view)
        ]);
        
        throw new RuntimeException($error);
    }

    try {
        // Génération du PDF avec DomPDF
        $pdf = Pdf::loadView($view, $data)
                  ->setPaper('a4')
                  ->setOption('isRemoteEnabled', true)
                  ->setOption('defaultFont', 'DejaVu Sans');

        // Création du dossier si inexistant
        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
            Log::info('📁 Directory created', ['dir' => $dir]);
        }

        // Écriture du PDF final
        $result = file_put_contents($outputPath, $pdf->output());
        
        if ($result === false) {
            throw new RuntimeException("Impossible d'écrire le fichier PDF: {$outputPath}");
        }

        Log::info('✅ PDF SERVICE SUCCESS', [
            'view' => $view,
            'output_path' => $outputPath,
            'file_size' => filesize($outputPath)
        ]);

    } catch (\Exception $e) {
        Log::error('❌ PDF SERVICE FAILED', [
            'view' => $view,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        throw new RuntimeException("Erreur génération PDF: " . $e->getMessage());
    }
}

/**
 * Trouve les vues disponibles dans le même chemin
 */
private function getViewsInPath(string $view): array
{
    $parts = explode('.', $view);
    if (count($parts) < 3) return [];
    
    // pdf.nova.desembouage.devis -> pdf/nova/desembouage
    $dirParts = array_slice($parts, 0, -1);
    $path = resource_path('views/' . implode('/', $dirParts));
    
    $views = [];
    if (is_dir($path)) {
        $files = scandir($path);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'blade.php') {
                $viewName = pathinfo($file, PATHINFO_FILENAME);
                $fullViewName = implode('.', $dirParts) . '.' . $viewName;
                $views[] = $fullViewName;
            }
        }
    }
    
    return $views;
}
}
