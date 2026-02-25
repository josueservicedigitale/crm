<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Pagination Bootstrap 5
        Paginator::useBootstrapFive();

        if (request()->isSecure()) {
            URL::forceScheme('https');
        }

        // Sidebar data
        View::composer('back.layouts.sidebar', function ($view) {

            $activites = \App\Models\Activite::active()
                ->orderBy('nom')
                ->get()
                ->mapWithKeys(fn ($a) => [$a->code => $a->nom])
                ->toArray();

            $societes = \App\Models\Societe::active()
                ->orderBy('nom')
                ->get()
                ->mapWithKeys(fn ($s) => [$s->code => $s->nom])
                ->toArray();

            $view->with([
                'activites' => $activites,
                'societes' => $societes,
                'currentActivity' => session('current_activity') ?? request('activity'),
                'currentSociety'  => session('current_society') ?? request('society'),
            ]);
        });
    }
}