<?php

namespace Modules\PkgEntretienIndividuel\Http\Controllers;

use App\Http\Controllers\Controller;   
use Modules\PkgEntretienIndividuel\Services\ApprenantService;

class ApprenantController extends Controller  
{
    private $apprenantService;

    public function __construct(ApprenantService $apprenantService)                       
    {
        $this->apprenantService = $apprenantService;
    }

    public function getApprenantsWithGroup()
    {
        return $this->apprenantService->getApprenantsWithGroup();
    }

}