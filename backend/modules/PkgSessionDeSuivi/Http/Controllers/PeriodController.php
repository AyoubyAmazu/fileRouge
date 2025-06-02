<?php

namespace Modules\PkgSessionDeSuivi\Http\Controllers;

use Modules\PkgSessionDeSuivi\Services\PeriodService;
use App\Http\Controllers\Controller;

class PeriodController extends Controller
{
    protected $periodService;
    
    public function __construct(PeriodService $periodService)
    {
        $this->periodService = $periodService;
    }
    
    public function getAll()
    {
        return $this->periodService->getAll();
    }
    public function activePeriods()
    {
        return $this->periodService->activePeriods();
    }
}
