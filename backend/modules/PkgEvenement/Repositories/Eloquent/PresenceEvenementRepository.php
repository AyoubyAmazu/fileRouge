<?php

namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Models\PresenceEvenement;
use Modules\pkgEvenement\Repositories\Interfaces\Icrud;

class PresenceEvenementRepository extends BaseReporistory implements Icrud
{
    public function __construct(PresenceEvenement $model)
    {
        parent::__construct($model);
    }

}
