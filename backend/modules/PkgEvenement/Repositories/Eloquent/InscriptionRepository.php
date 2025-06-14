<?php

namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Models\Inscription;
use Modules\pkgEvenement\Repositories\Interfaces\Icrud;

class InscriptionRepository extends BaseReporistory implements Icrud
{
    public function __construct(Inscription $model)
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
