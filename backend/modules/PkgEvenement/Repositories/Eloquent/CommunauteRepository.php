<?php

namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Models\Communaute;
use Modules\pkgEvenement\Repositories\Interfaces\Icrud;

class CommunauteRepository extends BaseReporistory implements Icrud
{

    public function __construct(Communaute $model)
    {

        parent::__construct( $model);
    }
    // You can add custom methods specific to the community repository here.
    public function countCommunaute()
    {

        return response()->json(['count' => $this->model->count()]);
    }

    public function getMembersByCommunaute(int $communauteId)
    {

        $members = $this->model->find($communauteId)->members()->with('user','groupe')->get();
        return response()->json($members);
    }




}





?>
