<?php

namespace Modules\PkgSessionDeSuivi\Domain\Interfaces;

interface PeriodRepositoryInterface
{
    public function getAll();
    public function activePeriods();

}
