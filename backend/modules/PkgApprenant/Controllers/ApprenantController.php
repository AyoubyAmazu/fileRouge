<?php
namespace Modules\PkgApprenant\Controllers;
use Illuminate\Http\Request;
use Modules\PkgApprenant\Models\Apprenant;
use App\Http\Controllers\Controller;
class ApprenantController extends Controller
{


   public function getMember()
    {
        $year = request()->query('year');

        $apprenantsQuery = Apprenant::whereHas('communautes');

        if ($year) {
            $apprenantsQuery->whereHas('groupe', function ($query) use ($year) {
                $query->where('annee_promotion', $year);
            });
        }

        $apprenants = $apprenantsQuery->with('communautes', 'user', 'groupe')->get();

        return response()->json([
            'message' => 'Communautes retrieved successfully',
            'data' => $apprenants
        ], 200);
    }

    public function updateCommunity(Request $request)
    {
        $id = $request->input('id_apprenant');
        $communauteIds = $request->input('communautes', []);
        $apprenant = Apprenant::find($id);
        if (empty($communauteIds)) {
            // Detach all communities if none are provided
            $apprenant->communautes()->detach();
            return response()->json([
            'message' => 'All communautes detached successfully',
            'data' => $apprenant->communautes
            ], 200);
        }else{
            $apprenant->communautes()->sync($communauteIds);
            return response()->json([
                'message' => 'Communautes updated successfully',
                'data' => $apprenant->communautes
            ], 200);
        }

    }


    public function addCommunuates(Request $request)
    {
        $id = $request->input('id_apprenant');
        $communauteIds = $request->input('communautes', []);
        $apprenant = Apprenant::find($id);
        if (empty($communauteIds)) {
            return response()->json([
                'message' => 'No communautes provided',
            ], 400);
        } else {
            $apprenant->communautes()->attach($communauteIds);
            return response()->json([
                'message' => 'Communautes added successfully',
                'data' => $apprenant->communautes
            ], 200);
        }
    }

    public function getAll()
    {
        $apprenant = Apprenant::all();
        return response()->json([
            'message' => 'Apprenants retrieved successfully',
            'data' => $apprenant
        ], 200);
    }

    public function apprenantWithNoCommunity()
    {
        $year = now()->year;
       $apprenantsQuery = Apprenant::doesntHave('communautes');
        if ($year) {
            $apprenantsQuery->whereHas('groupe', function ($query) use ($year) {
                $query->where('annee_promotion', $year);
            });
        }

        $apprenants = $apprenantsQuery->with('communautes', 'user', 'groupe')->get();

        return response()->json([
            'message' => 'Communautes retrieved successfully',
            'data' => $apprenants
        ], 200);
    }


    public function totalMembers($year = null)
    {
        $query = Apprenant::whereHas('communautes');
        if ($year) {
            $query->whereHas('groupe', function ($q) use ($year) {
                $q->where('annee_promotion', $year);
            });
        }
        $count = $query->distinct('id')->count('id');
        return response()->json(['count' => $count]);
    }

    public function apprenantNoInscripe($id)
    {
        $query = Apprenant::whereDoesntHave('inscriptions', function($q) use ($id) {
            $q->where('evenement_id', $id);
        })->whereDoesntHave('communautes')->with('user','groupe')->get();

        return response()->json($query);
    }

}



?>
