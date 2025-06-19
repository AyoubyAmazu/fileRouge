<?php



namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Repositories\Interfaces\Icrud;
use Modules\pkgEvenement\Models\CommunauteMembre;

class CommunauteMembersRepository extends BaseReporistory implements Icrud
{
    protected $filterBy = 'groupes.annee_promotion'; // Assuming you want to filter by creation date
    protected $relations = ['apprenant.groupe','apprenant.user',"communaute"]; // Relations to eager load
    public function __construct(CommunauteMembre $model)
    {
        parent::__construct($model);
    }

     public function countMemberOfCommunaute(int $id)
    {
       $result = $this->model->where('communaute_id', $id)->count();
        return response()->json(['count' => $result]);
    }

    // Implement methods specific to community members repository here
    public function totalMembers($year)
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

   public function getMembersByCommunaute(int $communauteId)
    {

        return $this->model->where('communaute_id', $communauteId)->with($this->relations)->get();
    }

    public function getCommunitysByMember($id)
    {
        return $this->model->where('apprenant_id', $id)->with("communaute")->get();
    }
}
