<?php

namespace Modules\pkgEvenement\Services;
use Modules\pkgEvenement\Repositories\Eloquent\JourRepository;
class JourService extends BaseService
{
    protected $repository;


    public function __construct(JourRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    




}






?>
