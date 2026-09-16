<?php

namespace App\Providers;

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
     */
    public function boot(): void
    {
        \Filament\Forms\Components\FileUpload::configureUsing(function (\Filament\Forms\Components\FileUpload $fileUpload): void {
            $fileUpload->disk('public');
        });

        // Bagikan data profil desa secara otomatis ke view warga & layouts
        \Illuminate\Support\Facades\View::composer(['warga.*', 'layouts.*', 'partials.*'], function ($view): void {
            if (!isset($view->getData()['profil'])) {
                try {
                    $profil = \Illuminate\Support\Facades\Schema::hasTable('profil_desa') 
                        ? \App\Models\ProfilDesa::first() 
                        : null;
                    $view->with('profil', $profil);
                } catch (\Throwable $e) {
                    $view->with('profil', null);
                }
            }
        });
    }
}
