<?php

namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Models\Formateur;
use Modules\pkgEvenement\Repositories\Interfaces\Icrud;

class FormateurRepository extends BaseReporistory implements Icrud
{
    public function __construct(Formateur $model)
    {
        parent::__construct($model);
    }
}
