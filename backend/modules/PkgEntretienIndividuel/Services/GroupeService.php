<?php

namespace Modules\PkgEntretienIndividuel\Services;

use Modules\PkgEntretienIndividuel\Domain\Interfaces\IGroupe;

class GroupeService implements IGroupe
{
    protected $model;

    public function __construct(IGroupe $model)
    {
        $this->model = $model;
    }

    public function getAllGroupes()
    {
        return $this->model->getAllGroupes();
    }
}
