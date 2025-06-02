<?php

namespace Modules\PkgSessionDeSuivi\Domain\Interfaces;

interface StudentCheckinRepositoryInterface
{
    public function getAll();
    public function todayStudentCheckin();
    public function getStudentCheckinByPeriod( $promotionId = null);
    public function getStudentCheckinByPeriodAvg();
    public function getRecentStudentCheckins( $promotionId = null);
}
