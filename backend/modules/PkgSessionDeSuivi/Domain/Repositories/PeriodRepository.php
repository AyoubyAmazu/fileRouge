<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\PeriodRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Entities\Period;


class PeriodRepository implements PeriodRepositoryInterface
{
    protected $period;
    
    public function __construct(Period $period)
    {
        $this->period = $period;
    }
    public function getAll()
    {
        return $this->period->all();
    }
    public function activePeriods()
    {
        return $this->period->where('is_active',true)->count();
    }
    
}
