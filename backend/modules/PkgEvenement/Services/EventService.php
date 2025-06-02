<?php

namespace Modules\pkgEvenement\Services;

use Faker\Provider\Base;
use Illuminate\Console\Scheduling\Event;
use Modules\pkgEvenement\Repositories\Eloquent\EvenementRepository;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryEvenement;

class EventService extends BaseService
{

    protected $repository;

    public function __construct(EvenementRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function countEvent($year = null)
    {
        return $this->repository->countEvent($year);
    }
     public function getYears()
    {
        // Logic to retrieve years from the repository
        return $this->repository->getYears();
    }
}






?>
