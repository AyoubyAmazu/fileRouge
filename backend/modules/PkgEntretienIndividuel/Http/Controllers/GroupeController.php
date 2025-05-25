<?php

namespace Modules\PkgEntretienIndividuel\Http\Controllers; 
use Modules\PkgEntretienIndividuel\Services\GroupeService;
use App\Http\Controllers\Controller; 

use Illuminate\Http\Request;

class GroupeController extends Controller
{
    protected $groupeService;

    public function __construct(GroupeService $groupeService)
    {
        $this->groupeService = $groupeService;
    }
    
    public function getAllGroupes()
    {
        return response()->json([
            'data' => $this->groupeService->getAllGroupes()
        ],200);
    }
}
