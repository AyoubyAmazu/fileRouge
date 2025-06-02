<?php

namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Models\ChefDeCommunaute;
use Modules\pkgEvenement\Repositories\Interfaces\Icrud;

class ChefDeCommunauteRepository extends BaseReporistory implements Icrud
{
    public function __construct(ChefDeCommunaute $model)
    {
        parent::__construct($model);
    }
}

