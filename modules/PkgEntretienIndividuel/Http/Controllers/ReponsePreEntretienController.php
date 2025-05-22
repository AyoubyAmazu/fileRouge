<?php

namespace Modules\PkgEntretienIndividuel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\PkgEntretienIndividuel\Services\ReponsePreEntretienService;
use Http\Controllers\Controller; 

class ReponsePreEntretienController extends Controller
{
    private $reponsePreEntretienService;

    public function __construct(ReponsePreEntretienService $reponsePreEntretienService)
    {
        $this->reponsePreEntretienService = $reponsePreEntretienService;
    }

    public function getAll()
    {
        return $this->reponsePreEntretienService->getAll();
    }
    

    public function getById($id)
    {
        return $this->reponsePreEntretienService->getById($id);
    }
    
    public function create(Request $request )
    {
        return $this->reponsePreEntretienService->create($request->all());
    }
    
    public function update(Request $request, $id)
    {
        return $this->reponsePreEntretienService->update($id, $request->all());
    }
    
    public function delete($id)
    {
        return $this->reponsePreEntretienService->delete($id);
    }
}
