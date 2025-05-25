<?php

namespace Modules\PkgEntretienIndividuel\Providers;

use Illuminate\Support\ServiceProvider;

//fomulaire
use Modules\PkgEntretienIndividuel\Domain\Interfaces\IFormulaire;
use Modules\PkgEntretienIndividuel\Domain\Repositories\FormulaireRepository;
use Modules\PkgEntretienIndividuel\Services\FormulaireService;
use Modules\PkgEntretienIndividuel\Domain\Entities\Formulaire;

//question
use Modules\PkgEntretienIndividuel\Domain\Interfaces\IQuestion;
use Modules\PkgEntretienIndividuel\Domain\Repositories\QuestionRepository;
use Modules\PkgEntretienIndividuel\Services\QuestionService;
use Modules\PkgEntretienIndividuel\Domain\Entities\Question;

//entretien
use Modules\PkgEntretienIndividuel\Services\EntretienService;
use Modules\PkgEntretienIndividuel\Domain\Entities\Entretien;
use Modules\PkgEntretienIndividuel\Domain\Interfaces\IEntretien;
use Modules\PkgEntretienIndividuel\Domain\Repositories\EntretienRepository;


//optionReponse
use Modules\PkgEntretienIndividuel\Domain\Interfaces\IoptionReponse;
use Modules\PkgEntretienIndividuel\Domain\Repositories\OptionReponseRepository;
use Modules\PkgEntretienIndividuel\Services\OptionReponseService;
use Modules\PkgEntretienIndividuel\Domain\Entities\OptionReponse;

//user
use Modules\PkgEntretienIndividuel\Domain\Interfaces\IApprenant;
use Modules\PkgEntretienIndividuel\Domain\Repositories\ApprenantRepository;
use Modules\PkgEntretienIndividuel\Services\ApprenantService;
use Core\Models\User;

//preEntretienForm
use Modules\PkgEntretienIndividuel\Domain\Interfaces\IPreEntretien;
use Modules\PkgEntretienIndividuel\Domain\Repositories\PreEntretienRepository;
use Modules\PkgEntretienIndividuel\Services\PreEntretienService;
use Modules\PkgEntretienIndividuel\Domain\Entities\PreEntretien;

//reponsePreEntretien
use Modules\PkgEntretienIndividuel\Domain\Interfaces\IReponsePreEntretien;
use Modules\PkgEntretienIndividuel\Domain\Repositories\ReponsePreEntretienRepository;
use Modules\PkgEntretienIndividuel\Services\ReponsePreEntretienService;
use Modules\PkgEntretienIndividuel\Domain\Entities\ReponsePreEntretien;

//groupe
use Modules\PkgEntretienIndividuel\Domain\Interfaces\IGroupe;
use Modules\PkgEntretienIndividuel\Domain\Repositories\GroupeRepository;
use Modules\PkgEntretienIndividuel\Services\GroupeService;
use Modules\PkgApprenant\Models\Groupe;




class EntretienIndividuelServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register the interface to repository binding
        $this->app->bind(
            IFormulaire::class,
            FormulaireRepository::class
        );
        
        $this->app->bind(
            IQuestion::class,
            QuestionRepository::class
        );

        $this->app->bind(
            IoptionReponse::class,
            OptionReponseRepository::class
        );

        $this->app->bind(
            IEntretien::class,
            EntretienRepository::class
        );

        $this->app->bind(
            IApprenant::class,
            ApprenantRepository::class
        );
        
        // Register IGroupe repository
        $this->app->bind(
            IGroupe::class,
            GroupeRepository::class
        );

        // Register OptionReponseService
        $this->app->singleton(OptionReponseService::class, function ($app) {
            return new OptionReponseService($app->make(IoptionReponse::class));
        });

        // Register GroupeService
        $this->app->singleton(GroupeService::class, function ($app) {
            return new GroupeService($app->make(IGroupe::class));
        });
       
        
        // Register FormulaireService
        $this->app->singleton(FormulaireService::class, function ($app) {
            return new FormulaireService($app->make(IFormulaire::class));
        });
        
        // Register EntretienService
        $this->app->singleton(EntretienService::class, function ($app) {
            return new EntretienService($app->make(IEntretien::class));
        });   
        
        // Register QuestionService
        $this->app->singleton(QuestionService::class, function ($app) {
            return new QuestionService($app->make(IQuestion::class));
        });

        // Register UserService
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService($app->make(IUser::class));
        });

        // Register interfaces and their implementations
        $this->app->bind(
            IPreEntretien::class,
            PreEntretienRepository::class
        );

        // Register IReponsePreEntretien interface
        $this->app->bind(
            IReponsePreEntretien::class,
            ReponsePreEntretienRepository::class
        );

        // Register PreEntretienService
        $this->app->singleton(PreEntretienService::class, function ($app) {
            return new PreEntretienService($app->make(IPreEntretien::class));
        });

        // Register ReponsePreEntretienService
        $this->app->singleton(ReponsePreEntretienService::class, function ($app) {
            return new ReponsePreEntretienService($app->make(IReponsePreEntretien::class));
        });

        // Register GroupeService
        $this->app->singleton(GroupeService::class, function ($app) {
            return new GroupeService($app->make(IGroupe::class));
        });
    }

    public function boot()
    {
        // Load core migrations first
        $this->loadMigrationsFrom(base_path('app/migrations'));
        
        // Then load module migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        
        // Choose ONE of these approaches, not both:
        
        // Option 1: Load routes without prefix
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        
        // Option 2: Load routes with 'api' prefix (recommended for API routes)
        $this->app['router']->prefix('api')->group(__DIR__ . '/../Routes/api.php');
    }
}