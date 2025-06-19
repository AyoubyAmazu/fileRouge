<?php
namespace Modules\PkgEvenement\Controllers;
use Illuminate\Http\Request;
use Modules\PkgEvenement\Services\InscriptionService;
use App\Http\Controllers\Controller;

class InscriptionController extends Controller
{
    protected $inscriptionService;

    public function __construct(InscriptionService $inscriptionService)
    {
        $this->inscriptionService = $inscriptionService;
    }

    public function countParticipent(Request $request)
    {
        $year = $request->query('year');
        return $this->inscriptionService->countParticipent($year);
    }

    public function countPresenceTotal(Request $request)
    {
        $year = $request->query('year');
        return $this->inscriptionService->countPresenceTotal($year);
    }

    public function countInscriptionByEvent(Request $request)
    {
        $id = $request->query('id');
        return $this->inscriptionService->countInscriptionByEvent($id);
    }

    public function countPresenceByEvent(Request $request)
    {
        $id = $request->query('id');
        return $this->inscriptionService->countPresenceByEvent($id);
    }
}



?>
