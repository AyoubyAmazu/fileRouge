<?php

namespace Modules\PkgEntretienIndividuel\Domain\Repositories;

use Modules\PkgEntretienIndividuel\Domain\Entities\Entretien;
use Modules\PkgEntretienIndividuel\Domain\Interfaces\IEntretien;
use Illuminate\Support\Facades\DB;

class EntretienRepository implements IEntretien
{
    protected $model;
    public function __construct(Entretien $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->find($id)->update($data);
    }
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
    public function getUpcomingEntretiensCount()
{
    return $this->model->where('statut', 'planifié')->count();
}
public function getInterviewCountByPromotion($promotion)
{
    return DB::table('entretiens')
        ->join('groupes', 'entretiens.groupe_id', '=', 'groupes.id')
        ->where('groupes.annee_promotion', $promotion)
        ->count();
}

}