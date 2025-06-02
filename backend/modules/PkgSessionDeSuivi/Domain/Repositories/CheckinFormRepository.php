<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;

use Modules\PkgSessionDeSuivi\Domain\Entities\CheckinForm;
use Modules\PkgSessionDeSuivi\Domain\Interfaces\CheckinFormRepositoryInterface;

class CheckinFormRepository implements CheckinFormRepositoryInterface
{
    protected $checkinFormRepository;
    public function __construct(CheckinForm $checkinFormRepository)
    {
        $this->checkinFormRepository = $checkinFormRepository;
    }
    public function getAll()
    {
        return $this->checkinFormRepository->all();
    }
    public function createFormWithQuestions($data)
    {
        return $this->checkinFormRepository->create($data);
        
    }
    public function getFormById($id){
        return $this->checkinFormRepository->find($id);
    }
    public function deleteFormQuestions($id){

        $getFormId = $this->getFormById($id);
        return $this->checkinFormRepository->delete($getFormId);
    }
}
