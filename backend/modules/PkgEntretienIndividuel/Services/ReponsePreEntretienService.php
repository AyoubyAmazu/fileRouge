<?php

namespace Modules\PkgEntretienIndividuel\Services;

use Modules\PkgEntretienIndividuel\Domain\Interfaces\IReponsePreEntretien;

class ReponsePreEntretienService implements IReponsePreEntretien
{
    protected $reponsePreEntretienRepository;

    public function __construct(IReponsePreEntretien $reponsePreEntretienRepository)
    {
        $this->reponsePreEntretienRepository = $reponsePreEntretienRepository;
    }

    public function getAll()
    {
        return $this->reponsePreEntretienRepository->getAll();
    }

    public function getById($id)
    {
        return $this->reponsePreEntretienRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->reponsePreEntretienRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->reponsePreEntretienRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->reponsePreEntretienRepository->delete($id);
    }
}

    
    
    
