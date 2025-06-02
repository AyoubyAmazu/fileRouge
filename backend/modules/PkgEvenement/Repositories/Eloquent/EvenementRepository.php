<?php

namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Models\Evenement;
use Modules\pkgEvenement\Repositories\Interfaces\Icrud;

class EvenementRepository extends BaseReporistory implements Icrud
{
    public function __construct(Evenement $model)
    {
        parent::__construct($model);
    }

    public function all($year = null)
    {
        if ($year) {
            return $this->model->whereYear('date_debut', $year)->with('jours')->get();
        }

        // If no year is specified, return all records with related 'jours'
        return $this->model->with('jours')->get();
    }


    public function countEvent($year)
    {
        $query = $this->model->newQuery();
        if ($year) {
            $query->whereYear('date_debut', $year);
        }
        return  response()->json(['count' => $query->count()]);

    }

    public function find(int $id)
    {
        return $this->model->with('jours')->findOrFail($id);
    }

      public function store(array $data)
    {
        $evenement = $this->model->create($data);
        $evenement->jours()->createMany($data["jours"]);
    }
    public function getYears()
    {
        return $this->model->selectRaw('YEAR(date_debut) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');
    }
}
