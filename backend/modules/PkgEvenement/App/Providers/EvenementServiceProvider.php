<?php

namespace Modules\pkgEvenement\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\pkgEvenement\Repositories\Eloquent\CommunauteRepository;
use Modules\PkgEvenement\Repositories\Eloquent\UserRepository;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryCommunaute;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryUser;

class EvenementServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IRepositoryUser::class, UserRepository::class);
        $this->app->bind(IRepositoryCommunaute::class, CommunauteRepository::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__."/../../Database/migrations");
        $this->loadRoutesFrom(__DIR__."/../../Routes/web.php");
        $this->loadRoutesFrom(__DIR__."/../../Routes/api.php");
        $this->app['router']->prefix('api')->group(__DIR__ . '/../../Routes/api.php');

    }
}
