<?php

namespace Modules\pkgEvenement\Services;
use Modules\pkgEvenement\Repositories\Eloquent\InscriptionRepository;

class InscriptionService extends BaseService
{
    protected $inscriptionRepository;

    public function __construct(InscriptionRepository $inscriptionRepository)
    {
        $this->inscriptionRepository = $inscriptionRepository;
    }

    public function countParticipent($year)
    {
        return $this->inscriptionRepository->countParticipent($year);
    }

    public function countPresenceTotal($year)
    {
        return $this->inscriptionRepository->countPresenceTotal($year);
    }

    public function countInscriptionByEvent($id)
    {
        return $this->inscriptionRepository->countInscriptionByEvent($id);
    }
    public function countPresenceByEvent($id)
    {
        return $this->inscriptionRepository->countPresenceByEvent($id);
    }

}



?>
