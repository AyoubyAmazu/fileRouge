<?php



namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Repositories\Interfaces\Icrud;
use Modules\pkgEvenement\Models\CommunauteMembre;

class CommunauteMembersRepository extends BaseReporistory implements Icrud
{
    public function __construct(CommunauteMembre $model)
    {
        parent::__construct($model);
    }

     public function all($year = null)
    {
        if ($year) {
            return $this->model->whereYear('created_at', $year)
                ->with('apprenant.user', 'communaute')
                ->get();
        }
        return $this->model->with('apprenant.user','communaute')->get();
    }


    // Implement methods specific to community members repository here
    public function countMembers($year)
    {
        // Logic to count community members
        $query = $this->model->newQuery();
        if ($year) {
        $query->whereHas('apprenant.groupe', function($q) use ($year) {
            $q->where('annee_promotion', $year);
        });        }
        $count = $query->distinct('apprenant_id')->count('apprenant_id');
        return response()->json(['count' => $count]);
   }

}
