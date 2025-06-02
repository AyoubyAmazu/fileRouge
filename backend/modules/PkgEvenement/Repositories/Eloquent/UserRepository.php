<?php

namespace Modules\PkgEvenement\Repositories\Eloquent;

use App\Models\User;
use Modules\pkgEvenement\Repositories\Interfaces\Icrud;

class UserRepository extends BaseReporistory implements Icrud
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
