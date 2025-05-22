<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\PkgEvenement\App\EvenmentServiceProvider\EvenmentServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(EvenmentServiceProvider::class); 
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
