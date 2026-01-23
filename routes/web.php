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
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('back')->middleware(['auth'])->name('back.')->group(function () {

    // =========================================================================
    // ACTIVITÉS
    // =========================================================================
    Route::get('activites', [ActiviteController::class, 'index'])->name('activite.index');
    Route::get('activites/create', [ActiviteController::class, 'create'])->name('activite.create');
    Route::post('activites', [ActiviteController::class, 'store'])->name('activite.store');
    Route::get('activites/{activite}', [ActiviteController::class, 'show'])->name('activite.show');
    Route::get('activites/{activite}/edit', [ActiviteController::class, 'edit'])->name('activite.edit');
    Route::put('activites/{activite}', [ActiviteController::class, 'update'])->name('activite.update');
    Route::delete('activites/{activite}', [ActiviteController::class, 'destroy'])->name('activite.destroy');
    Route::get('activites/{activite}/documents', [ActiviteController::class, 'documents'])->name('activite.documents');

    // =========================================================================
    // SOCIÉTÉS
    // =========================================================================
    Route::get('societes', [SocieteController::class, 'index'])->name('societe.index');
    Route::get('societes/create', [SocieteController::class, 'create'])->name('societe.create');
    Route::post('societes', [SocieteController::class, 'store'])->name('societe.store');
    Route::get('societes/{societe}', [SocieteController::class, 'show'])->name('societe.show');
    Route::get('societes/{societe}/edit', [SocieteController::class, 'edit'])->name('societe.edit');
    Route::put('societes/{societe}', [SocieteController::class, 'update'])->name('societe.update');
    Route::delete('societes/{societe}', [SocieteController::class, 'destroy'])->name('societe.destroy');
    Route::get('societes/{societe}/documents', [SocieteController::class, 'documents'])->name('societe.documents');

    // =========================================================================
    // DASHBOARD PRINCIPAL
    // =========================================================================
    Route::get('{activity}/{society}', [DocumentController::class, 'dashboard'])->name('dashboard');
    Route::get('all-dashboards', [DocumentController::class, 'allDashboards'])->name('all-dashboards');
    // Route pour la prévisualisation
    Route::get('{activity}/{society}/{type}/{document}/preview', [DocumentController::class, 'preview'])
        ->name('document.preview');

    Route::get('documents/creation-rapide', [DocumentController::class, 'creationRapide'])
        ->name('documents.creation-rapide');
    Route::get('/documents', [DocumentController::class, 'tousDocuments'])
        ->name('documents.tous');

    // =========================================================================
    // DOCUMENTS
    // =========================================================================
    Route::get('{activity}/{society}/{type}/choose', [DocumentController::class, 'chooseAction'])->name('document.choose');
    Route::get('{activity}/{society}/{type}/select-devis', [DocumentController::class, 'selectDevis'])->name('document.select-devis');
    Route::get('{activity}/{society}/cahier-des-charges/select-devis', [DocumentController::class, 'selectDevisForCahier'])->name('document.select-devis-cahier');
    Route::get('{activity}/{society}/select-facture', [DocumentController::class, 'selectFactureForRapport'])->name('document.select-facture-for-rapport');

    Route::get('{activity}/{society}/{type}/create', [DocumentController::class, 'create'])->name('document.create');
    Route::get('{activity}/{society}/facture/create/{devisId}', [DocumentController::class, 'createFacture'])->name('document.facture.create');
    Route::get('{activity}/{society}/attestation_realisation/create/{devis}', [DocumentController::class, 'createAttestationFromDevis'])->name('document.attestation.create');
    Route::get('{activity}/{society}/attestation_signataire/create/{devis}', [DocumentController::class, 'createAttestationSignataireFromDevis'])->name('document.attestation-signataire.create');
    Route::get('{activity}/{society}/cahier-des-charges/create/{devis}', [DocumentController::class, 'createCahierDesChargesFromDevis'])->name('document.cahier-des-charges.create');
    Route::get('{activity}/{society}/rapport/create/{facture}', [DocumentController::class, 'createRapportFromFacture'])->name('document.rapport.create');

    Route::post('{activity}/{society}/{type}/store', [DocumentController::class, 'store'])->name('document.store');
    Route::get('{activity}/{society}/{type}/edit', [DocumentController::class, 'edit'])->name('document.edit');
    Route::put('{activity}/{society}/{type}/{document}', [DocumentController::class, 'update'])->name('document.update');
    Route::delete('{activity}/{society}/{type}/{document}', [DocumentController::class, 'destroy'])->name('document.destroy');
    Route::get('{activity}/{society}/{type}/list', [DocumentController::class, 'listDocuments'])->name('document.list');
    Route::get('{activity}/{society}/{type}/{document}/show', [DocumentController::class, 'show'])->name('document.show');
    Route::post('{activity}/{society}/{type}/search', [DocumentController::class, 'searchDocument'])->name('document.search');

});

require __DIR__ . '/auth.php';
