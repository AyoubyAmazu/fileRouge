<?php

namespace Modules\PkgEvenement\Repositories\Eloquent;

use App\Models\User;
use Modules\pkgEvenement\Repositories\Eloquent\BaseReporistory;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryUser;

class UserRepository extends BaseReporistory implements IRepositoryUser
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
