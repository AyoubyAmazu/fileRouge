<?php

namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Models\Evenement;
use Modules\pkgEvenement\Repositories\Interfaces\Icrud;

class EvenementRepository extends BaseReporistory implements Icrud
{
     protected $relations = ["evenement_jours"];
     protected $filterBy = 'date_debut'; // Assuming you want to filter by start date


    public function __construct(Evenement $model)
    {
        parent::__construct($model);
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
        return $this->model->with('Evenement_jours')->findOrFail($id);
    }

      public function store(array $data)
    {
        $evenement = $this->model->create($data);
        $evenement->Evenement_jours()->createMany($data["jours"]);
    }
    public function getYears()
    {
        return $this->model->selectRaw('YEAR(date_debut) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');
    }
    public function destroy(int $id)
    {
        $evenement = $this->model->findOrFail($id);
        $evenement->Evenement_jours()->delete();
        $evenement->delete();
    }

    public function update($id,  $data)
    {
        $evenement = $this->model->findOrFail($id);
        $evenement->update($data);
        if (isset($data['jours'])) {
            $evenement->Evenement_jours()->delete();
            $evenement->Evenement_jours()->createMany($data['jours']);
        }
        return $evenement;
    }
}
