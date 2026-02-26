<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\DocumentController;
use App\Http\Controllers\Back\ActiviteController;
use App\Http\Controllers\Back\SocieteController;
use App\Http\Controllers\Back\CorbeilleController;
use App\Http\Controllers\Back\ParametreController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\ConversationController;
use App\Http\Controllers\Back\NotificationController;
use App\Http\Controllers\Back\DossierController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// =========================================================================
// 1. ROUTES PUBLIQUES ET AUTH
// =========================================================================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home.dashboard');

// Auth routes (profil, etc.)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// =========================================================================
// 2. ROUTES BACK AVEC PRÉFIXE - ORDRE OPTIMISÉ
// =========================================================================
Route::prefix('back')->name('back.')->middleware('auth')->group(function () {

    // =====================================================================
    // 2.1 ROUTES DE RECHERCHE (FIXES)
    // =====================================================================
    Route::get('/search', [SearchController::class, 'global'])->name('search.global');
    Route::get('/search/ajax', [SearchController::class, 'ajax'])->name('search.ajax');

    // =====================================================================
    // 2.2 ROUTES DOCUMENTS GLOBALES (SANS PARAMÈTRES)
    // =====================================================================
    Route::get('/documents/creation-rapide', [DocumentController::class, 'creationRapide'])->name('documents.creation-rapide');
    Route::get('/documents/tous', [DocumentController::class, 'tousDocuments'])->name('documents.tous');
    Route::get('/all-dashboards', [DocumentController::class, 'allDashboards'])->name('all-dashboards');

    // =====================================================================
    // 2.3 ROUTES DE MESSAGERIE (PREFIXE SIMPLE)
    // =====================================================================
    Route::prefix('conversations')->name('messagerie.')->group(function () {
        // Routes FIXES (sans paramètres)
        Route::get('/', [ConversationController::class, 'index'])->name('index');
        Route::get('/messages/dropdown', [ConversationController::class, 'dropdown'])->name('dropdown');

        // Routes avec paramètre {user} (plus spécifique que {conversation})
        Route::get('/users/{user}/conversation', [ConversationController::class, 'startWithUser'])->name('start');

        // Routes avec paramètre {conversation}
        Route::get('/{conversation}', [ConversationController::class, 'show'])->name('show');
        Route::post('/{conversation}/send', [ConversationController::class, 'sendMessage'])->name('send');
        Route::post('/{conversation}/upload', [ConversationController::class, 'uploadFile'])->name('upload');
        Route::post('/{conversation}/typing', [ConversationController::class, 'typing'])->name('typing');
        Route::post('/{conversation}/read', [ConversationController::class, 'markAsRead'])->name('read');

        // ✅ modifier / supprimer
        Route::patch('/{conversation}/messages/{message}', [ConversationController::class, 'updateMessage'])->name('messages.update');
        Route::delete('/{conversation}/messages/{message}', [ConversationController::class, 'deleteMessage'])->name('messages.delete');
    });

    // =====================================================================
    // 2.4 ROUTES DOSSIERS (ORDRE CRITIQUE)
    // =====================================================================
    Route::prefix('dossiers')->name('dossiers.')->group(function () {
        // Routes fixes
        Route::get('/create', [DossierController::class, 'create'])->name('create');
        Route::get('/', [DossierController::class, 'index'])->name('index');
        Route::post('/', [DossierController::class, 'store'])->name('store');

        // Routes avec paramètres spécifiques en **premier**
        Route::get('/{id}/edit', [DossierController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DossierController::class, 'update'])->name('update');
        Route::delete('/{id}', [DossierController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/upload', [DossierController::class, 'upload'])->name('upload');
        Route::get('/{id}/download', [DossierController::class, 'downloadDossier'])->name('download');
        Route::post('/{id}/toggle-visibilite', [DossierController::class, 'toggleVisibilite'])->name('toggle-visibilite');
        Route::post('/{id}/partager', [DossierController::class, 'partager'])->name('partager');

        // Route générique **à la fin**
        Route::get('/{slug}', [DossierController::class, 'show'])->name('show');
    });
    // =====================================================================
    // 2.5 ROUTES FICHIERS
    // =====================================================================
    Route::prefix('fichiers')->name('fichiers.')->group(function () {
        Route::get('/{id}/download', [DossierController::class, 'downloadFichier'])->name('download');
        Route::delete('/{id}', [DossierController::class, 'destroyFichier'])->name('destroy');
    });

    // =====================================================================
    // 2.6 ROUTES CRUD POUR SOCIÉTÉS
    // =====================================================================
    Route::prefix('societes')->name('societes.')->group(function () {
        // Routes FIXES
        Route::get('/create', [SocieteController::class, 'create'])->name('create');
        Route::get('/', [SocieteController::class, 'index'])->name('index');
        Route::post('/', [SocieteController::class, 'store'])->name('store');

        // Routes avec paramètre {societe}
        Route::get('/{societe}', [SocieteController::class, 'show'])->name('show');
        Route::get('/{societe}/edit', [SocieteController::class, 'edit'])->name('edit');
        Route::put('/{societe}', [SocieteController::class, 'update'])->name('update');
        Route::delete('/{societe}', [SocieteController::class, 'destroy'])->name('destroy');
        Route::post('/{societe}/toggle', [SocieteController::class, 'toggle'])->name('toggle');
        Route::get('/{societe}/documents', [SocieteController::class, 'documents'])->name('documents');
        Route::get('/{societe}/export', [SocieteController::class, 'export'])->name('export');
        Route::get('/{societe}/stats', [SocieteController::class, 'stats'])->name('stats');
    });

    // =====================================================================
    // 2.7 ROUTES CRUD POUR ACTIVITÉS
    // =====================================================================
    Route::prefix('activites')->name('activites.')->group(function () {
        // Routes FIXES
        Route::get('/create', [ActiviteController::class, 'create'])->name('create');
        Route::get('/stats', [ActiviteController::class, 'stats'])->name('stats');
        Route::get('/', [ActiviteController::class, 'index'])->name('index');
        Route::post('/', [ActiviteController::class, 'store'])->name('store');

        // Routes avec paramètre {activite}
        Route::get('/{activite}', [ActiviteController::class, 'show'])->name('show');
        Route::get('/{activite}/edit', [ActiviteController::class, 'edit'])->name('edit');
        Route::put('/{activite}', [ActiviteController::class, 'update'])->name('update');
        Route::delete('/{activite}', [ActiviteController::class, 'destroy'])->name('destroy');
        Route::post('/{activite}/toggle', [ActiviteController::class, 'toggle'])->name('toggle');
        Route::get('/{activite}/documents', [ActiviteController::class, 'documents'])->name('documents');
    });

    // =====================================================================
    // 2.8 ROUTES CRUD POUR UTILISATEURS
    // =====================================================================
    Route::prefix('users')->name('users.')->group(function () {
        // Routes FIXES
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');

        // Routes avec paramètre {id}
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{id}/restore', [UserController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [UserController::class, 'forceDelete'])->name('force-delete');
    });

    // =====================================================================
    // 2.9 ROUTES PARAMÈTRES
    // =====================================================================
    Route::prefix('parametres')->name('parametres.')->group(function () {
        // Routes FIXES
        Route::get('/creer', [ParametreController::class, 'create'])->name('create');
        Route::post('/mise-a-jour-masse', [ParametreController::class, 'updateEnMasse'])->name('update-masse');
        Route::post('/restaurer-defauts', [ParametreController::class, 'restaurerDefauts'])->name('restaurer-defauts');
        Route::get('/', [ParametreController::class, 'index'])->name('index');
        Route::post('/', [ParametreController::class, 'store'])->name('store');

        // Routes avec paramètre {parametre} (avec contrainte numérique)
        Route::get('/{parametre}', [ParametreController::class, 'show'])->name('show')->where('parametre', '[0-9]+');
        Route::get('/{parametre}/modifier', [ParametreController::class, 'edit'])->name('edit')->where('parametre', '[0-9]+');
        Route::put('/{parametre}', [ParametreController::class, 'update'])->name('update')->where('parametre', '[0-9]+');
        Route::delete('/{parametre}', [ParametreController::class, 'destroy'])->name('destroy')->where('parametre', '[0-9]+');
    });

    // =====================================================================
    // 2.10 ROUTES NOTIFICATIONS
    // =====================================================================
    Route::prefix('notifications')->name('notifications.')->group(function () {
        // Routes FIXES
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::get('/', [NotificationController::class, 'index'])->name('index');

        // Routes avec paramètre {id}
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
    });

    // =====================================================================
    // 2.11 ROUTES CORBEILLE
    // =====================================================================
    Route::prefix('corbeille')->name('corbeille.')->group(function () {
        // Routes FIXES
        Route::get('/vider-formulaire', [CorbeilleController::class, 'formulaireVider'])->name('vider-formulaire');
        Route::post('/vider', [CorbeilleController::class, 'viderCorbeille'])->name('vider');
        Route::get('/restaurer-tous-formulaire', [CorbeilleController::class, 'formulaireRestaurerTous'])->name('restaurer-tous-formulaire');
        Route::post('/restaurer-tous', [CorbeilleController::class, 'restaurerTous'])->name('restaurer-tous');
        Route::get('/telecharger-rapport', [CorbeilleController::class, 'telechargerRapport'])->name('telecharger-rapport');
        Route::post('/actions-groupées', [CorbeilleController::class, 'actionsGroupées'])->name('actions-groupées');
        Route::get('/', [CorbeilleController::class, 'index'])->name('index');

        // Routes avec paramètre {type}
        Route::get('/type/{type}', [CorbeilleController::class, 'parType'])->name('par-type');

        // Routes avec paramètre {id}
        Route::get('/{id}/afficher', [CorbeilleController::class, 'afficher'])->name('afficher');
        Route::post('/{id}/restaurer', [CorbeilleController::class, 'restaurer'])->name('restaurer');
        Route::delete('/{id}/supprimer-definitivement', [CorbeilleController::class, 'supprimerDefinitivement'])->name('supprimer-definitivement');
    });

    // =====================================================================
    // 2.12 ROUTES SPÉCIFIQUES DOCUMENTS (AVEC PARAMÈTRES FIXES)
    // =====================================================================
    // Routes de création avec parent explicite
    Route::get('/{activity}/{society}/facture/create/{devisId}', [DocumentController::class, 'createFacture'])
        ->name('document.facture.create');
    Route::get('/{activity}/{society}/attestation_realisation/create/{devis}', [DocumentController::class, 'createAttestationFromDevis'])
        ->name('document.attestation.create');
    Route::get('/{activity}/{society}/attestation_signataire/create/{devis}', [DocumentController::class, 'createAttestationSignataireFromDevis'])
        ->name('document.attestation-signataire.create');
    Route::get('/{activity}/{society}/cahier-des-charges/create/{devis}', [DocumentController::class, 'createCahierDesChargesFromDevis'])
        ->name('document.cahier-des-charges.create');
    Route::get('/{activity}/{society}/rapport/create/{facture}', [DocumentController::class, 'createRapportFromFacture'])
        ->name('document.rapport.create');

    // Routes de sélection
    Route::get('/{activity}/{society}/{type}/choose', [DocumentController::class, 'chooseAction'])
        ->name('document.choose');
    Route::get('/{activity}/{society}/{type}/choose-action', [DocumentController::class, 'chooseAction'])
        ->name('document.choose-action');
    Route::get('/{activity}/{society}/{type}/select-devis', [DocumentController::class, 'selectDevis'])
        ->name('document.select-devis');
    Route::get('/{activity}/{society}/cahier-des-charges/select-devis', [DocumentController::class, 'selectDevisForCahier'])
        ->name('document.select-devis-cahier');
    Route::get('/{activity}/{society}/select-facture', [DocumentController::class, 'selectFactureForRapport'])
        ->name('document.select-facture-for-rapport');

    // =====================================================================
    // 2.13 ROUTES DE CRÉATION GÉNÉRIQUE
    // =====================================================================
    Route::get('/{activity}/{society}/{type}/create', [DocumentController::class, 'create'])->name('document.create');
    Route::post('/{activity}/{society}/{type}/store', [DocumentController::class, 'store'])->name('document.store');

    // =====================================================================
    // 2.14 ROUTES AVEC 4 PARAMÈTRES (DOCUMENT ID)
    // =====================================================================
    Route::get('/{activity}/{society}/{type}/{document}/preview', [DocumentController::class, 'previewPDF'])->name('document.preview');
    Route::get('/{activity}/{society}/{type}/{document}/show', [DocumentController::class, 'show'])->name('document.show');
    Route::get('/{activity}/{society}/{type}/{document}/edit', [DocumentController::class, 'edit'])->name('document.edit');
    Route::put('/{activity}/{society}/{type}/{document}', [DocumentController::class, 'update'])->name('document.update');
    Route::delete('/{activity}/{society}/{type}/{document}', [DocumentController::class, 'destroy'])->name('document.destroy');
    Route::get('/{activity}/{society}/{type}/{document}/download', [DocumentController::class, 'downloadPDF'])->name('document.download');
    Route::get('/{activity}/{society}/{type}/{document}/regenerate-pdf', [DocumentController::class, 'regeneratePDF'])->name('document.regenerate');
    Route::post('/{activity}/{society}/{type}/{document}/generate-pdf', [DocumentController::class, 'generatePDF'])->name('document.generate_pdf');

    // =====================================================================
    // 2.15 ROUTES AVEC 2 PARAMÈTRES (DASHBOARD)
    // =====================================================================
    Route::get('/{activity}/{society}', [DocumentController::class, 'dashboard'])->name('dashboard');
    Route::get('/{activity}/{society}/{type}/list', [DocumentController::class, 'listDocuments'])->name('document.list');
    Route::post('/{activity}/{society}/{type}/search', [DocumentController::class, 'searchDocument'])->name('document.search');
});

// =========================================================================
// 3. ROUTES SUPPLÉMENTAIRES
// =========================================================================
Route::post('/logout-other-sessions', function (Request $request) {
    Auth::logoutOtherDevices($request->password);
    return back()->with('success', 'Déconnexion effectuée sur tous les autres appareils.');
})->middleware('auth')->name('logout.other');

// =========================================================================
// 4. AUTH ROUTES
// =========================================================================
require __DIR__ . '/auth.php';