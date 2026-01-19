<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\DocumentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('back.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('back')->middleware(['auth'])->name('back.')->group(function () {

    // Dashboard société / activité
    Route::get('{activity}/{society}', [DocumentController::class, 'dashboard'])
        ->name('dashboard');

    // Choix action (devis, facture, attestation…)
    Route::get('{activity}/{society}/{type}/choose', [DocumentController::class, 'chooseAction'])
        ->name('document.choose');

    Route::prefix('documents')->name('document.')->group(function () {

        // 🟢 ROUTE GÉNÉRIQUE — SÉLECTION DE DEVIS (FACTURE / ATTESTATIONS)
        Route::get(
            '{activity}/{society}/{type}/select-devis',
            [DocumentController::class, 'selectDevis']
        )->name('select-devis');

        // Création simple (hors facture / attestations)
        Route::get('{activity}/{society}/{type}/create', [DocumentController::class, 'create'])
            ->name('create');

        // Création FACTURE depuis devis
        Route::get(
            '{activity}/{society}/facture/create/{devisId}',
            [DocumentController::class, 'createFacture']
        )->name('facture.create');

        // Création ATTESTATION RÉALISATION depuis devis
        Route::get(
            '{activity}/{society}/attestation_realisation/create/{devis}',
            [DocumentController::class, 'createAttestationFromDevis']
        )->name('attestation.create');

        // Création ATTESTATION SIGNATAIRE depuis devis
        Route::get(
            '{activity}/{society}/attestation_signataire/create/{devis}',
            [DocumentController::class, 'createAttestationSignataireFromDevis']
        )->name('attestation-signataire.create');

        
       Route::get('{activity}/{society}/cahier-des-charges/create/{devis}', [DocumentController::class, 'createCahierDesChargesFromDevis'])
    ->name('cahier-des-charges.create');

Route::get('{activity}/{society}/cahier-des-charges/select-devis', [DocumentController::class, 'selectDevisForCahier'])
    ->name('back.document.select-devis-cahier');




        // Enregistrement
        Route::post('{activity}/{society}/{type}/store', [DocumentController::class, 'store'])
            ->name('store');

        // Édition
        Route::get('{activity}/{society}/{type}/edit', [DocumentController::class, 'edit'])
            ->name('edit');

        // Recherche
        Route::post('{activity}/{society}/{type}/search', [DocumentController::class, 'searchDocument'])
            ->name('search');

        // Mise à jour
        Route::put('{activity}/{society}/{type}/{document}', [DocumentController::class, 'update'])
            ->name('update');

        // Suppression
        Route::delete('{activity}/{society}/{type}/{document}', [DocumentController::class, 'destroy'])
            ->name('destroy');

        // Liste
        Route::get('{activity}/{society}/{type}/list', [DocumentController::class, 'listDocuments'])
            ->name('list');

        // Sélection facture pour rapport
        Route::get('{activity}/{society}/select-facture', [DocumentController::class, 'selectFactureForRapport'])
            ->name('select_facture_for_rapport');

        // Création du rapport depuis une facture
        Route::get('{activity}/{society}/rapport/create/{facture}', [DocumentController::class, 'createRapportFromFacture'])
            ->name('rapport.create');


        // Affichage / téléchargement PDF
        Route::get('{activity}/{society}/{type}/{document}/show', [DocumentController::class, 'show'])
            ->name('show');
    });
});
// Dans web.php
Route::get('/admin/test-templates', function() {
    $pdfService = app(\App\Services\PdfFillService::class);
    
    // Tester tous les templates
    $results = [];
    $templates = $pdfService->listAvailableTemplates();
    
    foreach ($templates as $key => $info) {
        [$activity, $society, $type] = explode('.', $key);
        
        $results[] = [
            'key' => $key,
            'activity' => $activity,
            'society' => $society,
            'type' => $type,
            'template' => $info['template'],
            'exists' => $info['exists'],
            'path' => $info['path']
        ];
    }
    
    return view('back.test-templates', compact('results'));
});


// Dans routes/web.php (temporaire)
Route::get('/admin/check-template-files', function() {
    $directory = storage_path('app/pdf-templates');
    $files = scandir($directory);
    
    $pdfFiles = array_filter($files, function($file) {
        return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
    });
    
    $pdfService = app(\App\Services\PdfFillService::class);
    $mappedTemplates = array_values($pdfService->templateMap);
    
    $report = [
        'files_in_directory' => $pdfFiles,
        'templates_in_map' => $mappedTemplates,
        'missing_in_directory' => array_diff($mappedTemplates, $pdfFiles),
        'extra_in_directory' => array_diff($pdfFiles, $mappedTemplates)
    ];
    
    return response()->json($report);
});




require __DIR__.'/auth.php';
