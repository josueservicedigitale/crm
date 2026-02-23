<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        
    }

    /**
     * Bootstrap any application services.
     */// Dans votre contrôleur ou AppServiceProvider
public function boot()
{
    Paginator::useBootstrap();

    // Forcer https sur ngrok / prod
    if (env('APP_URL') && str_starts_with(env('APP_URL'), 'https')) {
        URL::forceScheme('https');
    }

    // Pour la dev locale sur localhost
    if (env('APP_ENV') === 'local' && str_starts_with(env('APP_URL'), 'http://localhost')) {
        URL::forceScheme('http');
    }

    Paginator::useBootstrapFive();
    View::composer('back.layouts.sidebar', function ($view) {
        // Pour les activités - tableau clé => label
        $activites = \App\Models\Activite::active()
            ->orderBy('nom')
            ->get()
            ->mapWithKeys(function ($activite) {
                return [$activite->code => $activite->nom];
            })
            ->toArray();
        
        // Pour les sociétés - tableau clé => label  
        $societes = \App\Models\Societe::active()
            ->orderBy('nom')
            ->get()
            ->mapWithKeys(function ($societe) {
                return [$societe->code => $societe->nom];
            })
            ->toArray();
        
        $view->with([
            'activites' => $activites,
            'societes' => $societes,
            'currentActivity' => session('current_activity') ?? request('activity'),
            'currentSociety' => session('current_society') ?? request('society'),
        ]);
    });
}

}
