<?php

namespace Modules\PkgEvenement\App\EvenmentServiceProvider;

use Illuminate\Support\ServiceProvider;

class EvenmentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__."/../../Routes/web.php");

        $this->loadMigrationsFrom(__DIR__."/../../Database/migrations");
      
        $this->loadViewsFrom(__DIR__."/../../Resources/views","Blog");
      
        $this->publishes(
            [
                __DIR__."/../../Resources/views" => resource_path("views/vendor/Blog")
            ],'Blog_views'
        );
    }
}
