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
            $query->whereHas('evenement',function($q) use ($year){
                $q->whereYear('date_debut', $year);
            });
        }
            return response()->json(['count' => $query->count()]);
    }

    public function countPresenceTotal($year)
    {
        $query = $this->model->where('est_present', 1);

        if ($year) {
            $query->whereHas('evenement', function ($q) use ($year) {
                $q->whereYear('date_debut', $year);
            });
        }

        return response()->json(['count' => $query->count()]);
    }

    public function countInscriptionByEvent($id)
    {
        $query = $this->model->where("evenement_id", $id)->count();
        return response()->json(['count' => $query]);
    }

    public function countPresenceByEvent($id)
    {
        $query = $this->model->where("evenement_id", $id)->where('est_present', 1)->count();
        return response()->json(['count' => $query]);
    }

    public function getInscriptionByEvent($id)
    {
        $inscriptions = $this->model->where("evenement_id", $id)->with('apprenant.user', 'evenement')->get();
        return response()->json($inscriptions);
    }
}
