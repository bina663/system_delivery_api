<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('template.admin', function ($view) {
            //$view->with('storeName', Config::first()->name ?? 'Ki Burguer');
            $view->with('storeName', 'Ki Burguer');
        });
    }
}
