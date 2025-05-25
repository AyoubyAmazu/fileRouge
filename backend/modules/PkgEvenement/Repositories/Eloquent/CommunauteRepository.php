<?php

namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Models\Communaute;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryCommunaute;

class CommunauteRepository extends BaseReporistory implements IRepositoryCommunaute
{

    public function __construct(Communaute $model)
    {

        parent::__construct( $model);
    }
    // You can add custom methods specific to the community repository here.
    public function countCommunaute()
    {
        return $this->model->count();
    }
}





?>
