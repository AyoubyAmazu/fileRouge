<?php

namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Models\Encadrant;
use Modules\pkgEvenement\Repositories\Interfaces\Icrud;

class EncadrantRepository extends BaseReporistory implements Icrud
{
    public function __construct(Encadrant $model)
    {
        parent::__construct($model);
    }
}
