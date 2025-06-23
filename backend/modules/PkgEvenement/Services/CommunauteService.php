<?php

namespace Modules\pkgEvenement\Services;

use Modules\pkgEvenement\Repositories\Eloquent\CommunauteRepository;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryCommunaute;

class CommunauteService extends BaseService
{
    // This service class can be used to encapsulate business logic related to communities.
    // For example, you might have methods to create, update, delete, or retrieve communities.
    protected $repository;
    public function __construct(CommunauteRepository $repository)
    {
        parent::__construct($repository);

        $this->repository = $repository;
    }
       public function countCommunaute()
    {
        // Logic to count communities
        return $this->repository->countCommunaute();
    }
    public function getMembersByCommunaute(int $communauteId)
    {
        // Logic to get members by community ID
        return $this->repository->getMembersByCommunaute($communauteId);
    }


}

