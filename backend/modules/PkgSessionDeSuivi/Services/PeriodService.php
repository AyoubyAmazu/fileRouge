<?php

namespace Modules\PkgSessionDeSuivi\Services;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\PeriodRepositoryInterface;

class PeriodService 
{
    protected $periodRepository;
    
    public function __construct(PeriodRepositoryInterface $periodRepository)
    {
        $this->periodRepository = $periodRepository;
    }
    public function getAll()
    {
        return $this->periodRepository->getAll();
    }
    public function activePeriods()
    {
        return $this->periodRepository->activePeriods();
    }
}
