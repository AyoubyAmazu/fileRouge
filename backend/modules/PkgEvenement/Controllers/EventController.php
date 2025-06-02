<?php

namespace Modules\pkgEvenement\Controllers;

use Modules\pkgEvenement\Services\EventService;

class EventController extends BaseController
{

    protected $service;
    public function __construct(EventService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }

    public function countEvent()

    {
        $year = request()->query('year',$year?? now()->year);
        return $this->service->countEvent($year);
    }
     public function getYears()
    {
        return $this->service->getYears();
    }

}






?>
