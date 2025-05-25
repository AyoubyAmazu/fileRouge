<?php

namespace Modules\pkgEvenement\Services;

use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryCommunaute;

class CommunauteService extends EventBaseService
{
    // This service class can be used to encapsulate business logic related to communities.
    // For example, you might have methods to create, update, delete, or retrieve communities.
    protected $repository;
    public function __construct(IRepositoryCommunaute $repository)
    {
        parent::__construct($repository);

        $this->repository = $repository;
    }
       public function countCommunaute()
    {
        // Logic to count communities
        return $this->repository->countCommunaute();
    }

}

