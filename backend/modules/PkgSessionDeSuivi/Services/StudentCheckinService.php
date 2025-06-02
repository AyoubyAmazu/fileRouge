<?php
namespace Modules\PkgSessionDeSuivi\Services;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\StudentCheckinRepositoryInterface;

class StudentCheckinService
{
    protected StudentCheckinRepositoryInterface $repository;

    public function __construct(StudentCheckinRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function todayStudentCheckin()
    {
        return $this->repository->todayStudentCheckin();
    }
    public function getStudentCheckinByPeriod($promotionId = null)
    {
        return $this->repository->getStudentCheckinByPeriod($promotionId);
    }
    public function getRecentStudentCheckins($promotionId = null)
    {
        return $this->repository->getRecentStudentCheckins($promotionId);
    }
    public function getStudentCheckinByPeriodAvg()
    {
        return $this->repository->getStudentCheckinByPeriodAvg();
    }
}
