<?php

namespace Modules\PkgEntretienIndividuel\Services;

use Modules\PkgEntretienIndividuel\Domain\Interfaces\IoptionReponse;
use Modules\PkgEntretienIndividuel\Domain\Repositories\OptionReponseRepository;

class OptionReponseService
{
    protected $optionReponseRepository;
    public function __construct(IoptionReponse $optionReponseRepository)
    {
        $this->optionReponseRepository = $optionReponseRepository;
    }
    public function getAll()
    {
        return $this->optionReponseRepository->all();
    }
    public function find($id)
    {
        return $this->optionReponseRepository->find($id);
    }
    public function create(array $data)
    {
        return $this->optionReponseRepository->create($data);
    }
    public function update($id, array $data)
    {
        return $this->optionReponseRepository->update($id, $data);
    }
    public function delete($id)
    {
        return $this->optionReponseRepository->delete($id);
    }
}   