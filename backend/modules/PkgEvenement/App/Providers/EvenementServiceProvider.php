<?php

namespace Modules\pkgEvenement\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\pkgEvenement\Repositories\Eloquent\ChefDeCommunauteRepository;
use Modules\pkgEvenement\Repositories\Eloquent\CommunauteMembersRepository;
use Modules\pkgEvenement\Repositories\Eloquent\CommunauteRepository;
use Modules\pkgEvenement\Repositories\Eloquent\EncadrantRepository;
use Modules\pkgEvenement\Repositories\Eloquent\EvenementRepository;
use Modules\pkgEvenement\Repositories\Eloquent\FormateurRepository;
use Modules\pkgEvenement\Repositories\Eloquent\ParticipantRepository;
use Modules\pkgEvenement\Repositories\Eloquent\PresenceEvenementRepository;
use Modules\PkgEvenement\Repositories\Eloquent\UserRepository;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryChefDeCommunaute;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryCommunaute;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryCommunauteMembers;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryEncadrant;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryEvenement;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryFormateur;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryParticipant;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryPresenceEvenement;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryUser;

class EvenementServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__."/../../Database/migrations");
        $this->loadRoutesFrom(__DIR__."/../../Routes/web.php");
        $this->loadRoutesFrom(__DIR__."/../../Routes/api.php");
        $this->app['router']->prefix('api')->group(__DIR__ . '/../../Routes/api.php');

    }
}
