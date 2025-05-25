<?php

namespace Modules\PkgEntretienIndividuel\Services;

use Modules\PkgEntretienIndividuel\Domain\Interfaces\IEntretien;
use Modules\PkgEntretienIndividuel\Domain\Repositories\EntretienRepository;

class EntretienService
{
    protected $entretienRepository;
    public function __construct(IEntretien $entretienRepository)
    {
        $this->entretienRepository = $entretienRepository;
    }

    public function getAll()
    {
        return $this->entretienRepository->all();
    }

    public function find($id)
    {
        return $this->entretienRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->entretienRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->entretienRepository->update($id, $data);
    }
    public function delete($id)
    {
        return $this->entretienRepository->delete($id);
    }
    public function getUpcomingEntretiensCount() 
    {
        return $this->entretienRepository->getUpcomingEntretiensCount(); 
    }
    public function getInterviewCountByPromotion($promotion)
    {
        return $this->entretienRepository->getInterviewCountByPromotion($promotion);
    }
}