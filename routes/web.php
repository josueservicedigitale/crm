<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\DocumentController;
use App\Http\Controllers\Back\ActiviteController;
use App\Http\Controllers\Back\SocieteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('back.dashboard');
})->middleware(['auth', 'verified'])->name('home.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================================================================
// ROUTES BACK - SANS PRÉFIXE MAIS AVEC MIDDLEWARE AUTH
// =========================================================================

// Routes document globales (SANS paramètres d'activité/société)
Route::middleware('auth')->group(function () {
    Route::get('/back/documents/creation-rapide', [DocumentController::class, 'creationRapide'])
        ->name('back.documents.creation-rapide');
    Route::get('/back/documents/tous', [DocumentController::class, 'tousDocuments'])
        ->name('back.documents.tous');
    Route::get('/back/all-dashboards', [DocumentController::class, 'allDashboards'])
        ->name('back.all-dashboards');
});

// Routes activités et sociétés
Route::middleware('auth')->group(function () {
    Route::get('/back/activites', [ActiviteController::class, 'index'])->name('back.activite.index');
    Route::get('/back/activites/create', [ActiviteController::class, 'create'])->name('back.activite.create');
    Route::post('/back/activites', [ActiviteController::class, 'store'])->name('back.activite.store');
    Route::get('/back/activites/{activite}', [ActiviteController::class, 'show'])->name('back.activite.show');
    Route::get('/back/activites/{activite}/edit', [ActiviteController::class, 'edit'])->name('back.activite.edit');
    Route::put('/back/activites/{activite}', [ActiviteController::class, 'update'])->name('back.activite.update');
    Route::delete('/back/activites/{activite}', [ActiviteController::class, 'destroy'])->name('back.activite.destroy');
    Route::get('/back/activites/{activite}/documents', [ActiviteController::class, 'documents'])->name('back.activite.documents');

    Route::get('/back/societes', [SocieteController::class, 'index'])->name('back.societe.index');
    Route::get('/back/societes/create', [SocieteController::class, 'create'])->name('back.societe.create');
    Route::post('/back/societes', [SocieteController::class, 'store'])->name('back.societe.store');
    Route::get('/back/societes/{societe}', [SocieteController::class, 'show'])->name('back.societe.show');
    Route::get('/back/societes/{societe}/edit', [SocieteController::class, 'edit'])->name('back.societe.edit');
    Route::put('/back/societes/{societe}', [SocieteController::class, 'update'])->name('back.societe.update');
    Route::delete('/back/societes/{societe}', [SocieteController::class, 'destroy'])->name('back.societe.destroy');
    Route::get('/back/societes/{societe}/documents', [SocieteController::class, 'documents'])->name('back.societe.documents');
});

// =========================================================================
// ROUTES DOCUMENTS AVEC PARAMÈTRES - ORDRE CRITIQUE
// =========================================================================

// 1. D'abord les routes avec paramètres FIXES (les plus spécifiques)
Route::middleware('auth')->group(function () {
    // Routes de création avec parent EXPLICITE
    Route::get('/back/{activity}/{society}/facture/create/{devisId}', [DocumentController::class, 'createFacture'])
        ->name('back.document.facture.create');
    Route::get('/back/{activity}/{society}/attestation_realisation/create/{devis}', [DocumentController::class, 'createAttestationFromDevis'])
        ->name('back.document.attestation.create');
    Route::get('/back/{activity}/{society}/attestation_signataire/create/{devis}', [DocumentController::class, 'createAttestationSignataireFromDevis'])
        ->name('back.document.attestation-signataire.create');
    Route::get('/back/{activity}/{society}/cahier-des-charges/create/{devis}', [DocumentController::class, 'createCahierDesChargesFromDevis'])
        ->name('back.document.cahier-des-charges.create');
    Route::get('/back/{activity}/{society}/rapport/create/{facture}', [DocumentController::class, 'createRapportFromFacture'])
        ->name('back.document.rapport.create');
});

// 2. Ensuite les routes de sélection/choix
Route::middleware('auth')->group(function () {
    Route::get('/back/{activity}/{society}/{type}/choose', [DocumentController::class, 'chooseAction'])
        ->name('back.document.choose');
    Route::get('/back/{activity}/{society}/{type}/select-devis', [DocumentController::class, 'selectDevis'])
        ->name('back.document.select-devis');
    Route::get('/back/{activity}/{society}/cahier-des-charges/select-devis', [DocumentController::class, 'selectDevisForCahier'])
        ->name('back.document.select-devis-cahier');
    Route::get('/back/{activity}/{society}/select-facture', [DocumentController::class, 'selectFactureForRapport'])
        ->name('back.document.select-facture-for-rapport');
});

// 3. Route de création GÉNÉRIQUE (doit venir APRÈS les routes spécifiques)
Route::middleware('auth')->group(function () {
    Route::get('/back/{activity}/{society}/{type}/create', [DocumentController::class, 'create'])
        ->name('back.document.create');
});

// 4. Dashboard (2 paramètres)
Route::middleware('auth')->group(function () {
    Route::get('/back/{activity}/{society}', [DocumentController::class, 'dashboard'])
        ->name('back.dashboard');
});

// 5. Routes avec document ID (4 paramètres)
Route::middleware('auth')->group(function () {
    Route::get('/back/{activity}/{society}/{type}/{document}/preview', [DocumentController::class, 'preview'])
        ->name('back.document.preview');
    Route::get('/back/{activity}/{society}/{type}/{document}/show', [DocumentController::class, 'show'])
        ->name('back.document.show');
    Route::get('/back/{activity}/{society}/{type}/{document}/edit', [DocumentController::class, 'edit'])
        ->name('back.document.edit');

    Route::put('/back/{activity}/{society}/{type}/{document}', [DocumentController::class, 'update'])
        ->name('back.document.update');
    Route::delete('/back/{activity}/{society}/{type}/{document}', [DocumentController::class, 'destroy'])
        ->name('back.document.destroy');
    Route::get(
        '/back/{activity}/{society}/{type}',
        [DocumentController::class, 'chooseAction']
    )->name('back.document.choose-action');

});


Route::get(
    '/back/{activity}/{society}/{type}/{document}/download',
    [DocumentController::class, 'downloadPDF']
)
    ->name('back.document.download');

Route::get(
    '/back/{activity}/{society}/{type}/{document}/regenerate-pdf',
    [DocumentController::class, 'regeneratePDF']
)
    ->name('back.document.regenerate');
// 6. Routes POST (actions)
Route::middleware('auth')->group(function () {
    Route::post('/back/{activity}/{society}/{type}/store', [DocumentController::class, 'store'])
        ->name('back.document.store');
    Route::post('/back/{activity}/{society}/{type}/search', [DocumentController::class, 'searchDocument'])
        ->name('back.document.search');
});
Route::post('back/{activity}/{society}/{type}/{document}/generate-pdf', [DocumentController::class, 'generatePDF'])
    ->name('back.document.generate_pdf');

// 7. Routes LIST (en DERNIER - les plus génériques)
Route::middleware('auth')->group(function () {
    Route::get('/back/{activity}/{society}/{type}/list', [DocumentController::class, 'listDocuments'])
        ->name('back.document.list');
});

require __DIR__ . '/auth.php';