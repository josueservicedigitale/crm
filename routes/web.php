<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\DocumentController;
use App\Http\Controllers\Back\ActiviteController;
use App\Http\Controllers\Back\SocieteController;
use App\Http\Controllers\Back\CorbeilleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('back.dashboard');
})->middleware(['auth', 'verified'])->name('home.dashboard');

// Dans web.php
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});
// Dans web.php
Route::post('/logout-other-sessions', function (Request $request) {
    Auth::logoutOtherDevices($request->password);
    
    return back()->with('success', 'Déconnexion effectuée sur tous les autres appareils.');
})->middleware('auth')->name('logout.other');

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

// Routes pour les sociétés
Route::prefix('back/societes')->name('back.societes.')->group(function () {
    Route::get('/', [SocieteController::class, 'index'])->name('index');
    Route::get('/create', [SocieteController::class, 'create'])->name('create');
    Route::post('/', [SocieteController::class, 'store'])->name('store');
    Route::get('/{societe}', [SocieteController::class, 'show'])->name('show');
    Route::get('/{societe}/edit', [SocieteController::class, 'edit'])->name('edit');
    Route::put('/{societe}', [SocieteController::class, 'update'])->name('update');
    Route::delete('/{societe}', [SocieteController::class, 'destroy'])->name('destroy');
    Route::post('/{societe}/toggle', [SocieteController::class, 'toggle'])->name('toggle');
    Route::get('/{societe}/documents', [SocieteController::class, 'documents'])->name('documents');
    Route::get('/{societe}/export', [SocieteController::class, 'export'])->name('export');
    Route::get('/{societe}/stats', [SocieteController::class, 'stats'])->name('stats');
});
// Version 1 : Avec prefix 'back' + name 'back.'
Route::prefix('back')->name('back.')->group(function () {
    // Toutes les routes des activités
    Route::prefix('activites')->name('activites.')->group(function () {
        // Routes principales
        Route::get('/', [ActiviteController::class, 'index'])->name('index');
        Route::get('/create', [ActiviteController::class, 'create'])->name('create');
        Route::post('/', [ActiviteController::class, 'store'])->name('store');
        Route::get('/{activite}/edit', [ActiviteController::class, 'edit'])->name('edit');
        Route::put('/{activite}', [ActiviteController::class, 'update'])->name('update');
        Route::delete('/{activite}', [ActiviteController::class, 'destroy'])->name('destroy');
        
        // ✅ Routes spécifiques - CORRECTES
        Route::post('/{activite}/toggle', [ActiviteController::class, 'toggle'])->name('toggle');
        Route::get('/stats', [ActiviteController::class, 'stats'])->name('stats'); // ✅ Pas de double "activites"
        
        // Optionnel : show (si nécessaire)
        Route::get('/{activite}', [ActiviteController::class, 'show'])->name('show');
    });
});

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




// =========================================================================
// ROUTES POUR LA CORBEILLE
// =========================================================================

// Dans votre fichier web.php
Route::prefix('back/corbeille')->name('back.corbeille.')->middleware('auth')->group(function () {
    // Page principale de la corbeille
    Route::get('/', [CorbeilleController::class, 'index'])->name('index');
    
    // Afficher les détails d'un élément
    Route::get('/{id}/afficher', [CorbeilleController::class, 'afficher'])->name('afficher');
    
    // Restaurer un élément
    Route::post('/{id}/restaurer', [CorbeilleController::class, 'restaurer'])->name('restaurer');
    
    // Supprimer définitivement
    Route::delete('/{id}/supprimer-definitivement', [CorbeilleController::class, 'supprimerDefinitivement'])->name('supprimer-definitivement');
    
    // Vider toute la corbeille
    Route::get('/vider-formulaire', [CorbeilleController::class, 'formulaireVider'])->name('vider-formulaire');
    Route::post('/vider', [CorbeilleController::class, 'viderCorbeille'])->name('vider');
    
    // Restaurer tous les éléments
    Route::get('/restaurer-tous-formulaire', [CorbeilleController::class, 'formulaireRestaurerTous'])->name('restaurer-tous-formulaire');
    Route::post('/restaurer-tous', [CorbeilleController::class, 'restaurerTous'])->name('restaurer-tous');
    
    // Filtrer par type
    Route::get('/type/{type}', [CorbeilleController::class, 'parType'])->name('par-type');
    
    // Télécharger un rapport
    Route::get('/telecharger-rapport', [CorbeilleController::class, 'telechargerRapport'])->name('telecharger-rapport');
    
    // Actions groupées
    Route::post('/actions-groupées', [CorbeilleController::class, 'actionsGroupées'])->name('actions-groupées');
});
require __DIR__ . '/auth.php';