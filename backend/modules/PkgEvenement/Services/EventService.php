<?php

namespace Modules\pkgEvenement\Services;

use Modules\pkgEvenement\Repositories\Eloquent\EvenementRepository;

class EventService extends BaseService
{

    protected $repository;
    protected $jourService;

    public function __construct(EvenementRepository $repository , JourService $jourService)
    {
        parent::__construct($repository);
        $this->repository = $repository;
        $this->jourService = $jourService;
    }
    public function countEvent($year = null)
    {
        return $this->repository->countEvent($year);
    }
     public function getYears()
    {
        return $this->repository->getYears();
    }

    public function update( $id,  $eventData)
    {
          if (isset($eventData['evenement_jours'])) {
            foreach ($eventData['evenement_jours'] as $jour) {
                if(!isset($jour["id"]) )
                 {
                   $Jour = $this->jourService->store($jour);
                    $jour->evenmenet()->attach($id);
                }
                else
                {
                    $this->jourService->update($jour["id"], $jour);
                }
        }
    }
        return $this->repository->update($id, $eventData);
    }

    public function upcomingEvents(){
        return $this->repository->upcomingEvents();
    }

}




?>
