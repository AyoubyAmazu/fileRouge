<?php

namespace Modules\PkgEntretienIndividuel\Services;

use Modules\PkgEntretienIndividuel\Domain\Interfaces\IPreEntretien;

class PreEntretienService
{
    protected $preEntretienRepository;

    public function __construct(IPreEntretien $preEntretienRepository)
    {
        $this->preEntretienRepository = $preEntretienRepository;
    }

    public function getAll()
    {
        $preEntretienRepository = $this->preEntretienRepository->all();
        return $preEntretienRepository;
    }

    public function create($data)
    {
        $preEntretienRepository = $this->preEntretienRepository->create($data);
        return $preEntretienRepository;
    }

    public function find($id)
    {
        $preEntretienRepository = $this->preEntretienRepository->find($id);
        return $preEntretienRepository;
    }

    public function update($id, $data)
    {
        $preEntretienRepository = $this->preEntretienRepository->update($id, $data);
        return $preEntretienRepository;
    }

    public function delete($id)
    {
        $preEntretienRepository = $this->preEntretienRepository->delete($id);
        return $preEntretienRepository;
    }
} 