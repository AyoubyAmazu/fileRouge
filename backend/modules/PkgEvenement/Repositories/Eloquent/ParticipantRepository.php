<?php

namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Models\Participant;
use Modules\pkgEvenement\Repositories\Interfaces\Icrud;

class ParticipantRepository extends BaseReporistory implements Icrud
{
    public function __construct(Participant $model)
    {
        parent::__construct($model);
    }
    public function countParticipent($year)
    {
    $query = $this->model->newQuery();
    if ($year) {
        $query->whereYear('created_at', $year);
    }
    return response()->json(['count' => $query->count()]);
    }
}
