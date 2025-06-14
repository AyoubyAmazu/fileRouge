<?php

namespace Modules\pkgEvenement\Controllers;


use Modules\PkgEvenement\Services\CommunauteService;

class CommunauteController extends BaseController{

    protected $service;
    public function __construct(CommunauteService $Communauteservice)
    {
        // You can add middleware or other initializations here if needed
        parent::__construct($Communauteservice);
        $this->service = $Communauteservice;
    }

    public function index()
    {
        $year = request()->query('year', $year ?? null);
        return $this->service->getAll($year);
    }

    public function countCommunaute()
    {
        // Logic to count communities
        return $this->service->countCommunaute(); // Assuming countCommunaute is a method in the service
    }

}
