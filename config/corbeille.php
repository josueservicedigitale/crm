<?php
// config/corbeille.php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration de la corbeille
    |--------------------------------------------------------------------------
    */
    
    // Nombre de jours avant expiration automatique
    'jours_conservation' => env('JOURS_CONSERVATION_CORBEILLE', 30),
    
    // Activer la notification d'expiration
    'notifications' => [
        'activer' => env('CORBEILLE_NOTIFICATIONS', true),
        'jours_avant_expiration' => 7, // Notifier 7 jours avant expiration
    ],
    
    // Types d'éléments à suivre dans la corbeille
    'types_suivis' => [     
        \App\Models\Societe::class,
        \App\Models\Activite::class,
        \App\Models\Document::class,
    ],
    
    // Exclusions (éléments qui ne vont pas dans la corbeille)
    'exclusions' => [
        // \App\Models\Log::class,
    ],
];