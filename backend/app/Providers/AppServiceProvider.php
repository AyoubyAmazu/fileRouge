<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\PkgEvenement\App\Providers\EvenementServiceProvider;
use Modules\PkgEntretienIndividuel\Providers\EntretienIndividuelServiceProvider;
use Modules\PkgApprenant\Providers\ApprenantServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(EvenementServiceProvider::class);
        $this->app->register(EntretienIndividuelServiceProvider::class);
        $this->app->register(ApprenantServiceProvider::class);
    }

    public function boot(): void
    {
        //
    }
}
