<?php

namespace Modules\pkgEvenement\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\PkgEvenement\Services\BaseService;

class BaseController extends Controller

{
    protected $service;
    function __construct(BaseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getAll();
    }

    public function find(int $id)
    {
        $id = request()->query('id',$id);
        return $this->service->find($id);
    }

    public function store(Request $request)
    {
        $eventData = $request->all();
        return $this->service->store($eventData);
    }



}




?>
