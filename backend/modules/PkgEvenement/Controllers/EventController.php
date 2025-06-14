<?php

namespace Modules\pkgEvenement\Controllers;

use Illuminate\Http\Request;
use Modules\pkgEvenement\Services\EventService;

class EventController extends BaseController
{

    protected $service;
    public function __construct(EventService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }
    public function index()
    {
        $year = request()->query('year', $year ?? null);
        return $this->service->getAll($year);
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

    public function update(Request $request, int $id)
    {
        $id = request()->query('id',$id);
        $eventData = $request->all();
        return $this->service->update($id, $eventData);
    }

}






?>
