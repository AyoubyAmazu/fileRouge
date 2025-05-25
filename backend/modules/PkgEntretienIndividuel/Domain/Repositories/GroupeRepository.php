<?php

namespace Modules\PkgEntretienIndividuel\Domain\Repositories;

use Modules\PkgEntretienIndividuel\Domain\Interfaces\IGroupe;
use Modules\PkgApprenant\Models\Groupe;

class GroupeRepository implements IGroupe
{
    protected $model;

    public function __construct(Groupe $model)
    {
        $this->model = $model;
    }

    public function getAllGroupes()
    {
        return $this->model->all();
    }
}
