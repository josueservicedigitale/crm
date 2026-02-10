<?php
// app/Providers/CorbeilleServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Corbeille;

class CorbeilleServiceProvider extends ServiceProvider
{
    /**
     * Enregistrer les services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Démarrer les services.
     */
    public function boot(): void
    {
        // Enregistrer les événements de suppression
        $this->enregistrerEvenementsCorbeille();
        
        // Publier la configuration
        $this->publishes([
            __DIR__.'/../../config/corbeille.php' => config_path('corbeille.php'),
        ], 'corbeille-config');
    }
    
    /**
     * Enregistrer les événements liés à la corbeille.
     */
    private function enregistrerEvenementsCorbeille(): void
    {
        // Vous pouvez ajouter des écouteurs d'événements ici si nécessaire
    }
}