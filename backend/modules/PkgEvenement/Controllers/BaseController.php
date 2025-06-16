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

    public function index( )
    {
        $year = request()->query('year', $year ?? now()->year);
        return $this->service->getAll($year );
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

    public function destroy(int $id)
    {
        $id = request()->query('id',$id);
        return $this->service->destroy($id);
    }

    public function update(Request $request,  $id)
    {
        $id = request()->query('id',$id);
        $eventData = $request->all();
        $this->service->update($id, $eventData);
        return response()->json(['message' => 'Event updated successfully']);
    }

}


?>
