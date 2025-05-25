<?php

namespace Modules\PkgEntretienIndividuel\Http\Controllers; 

use Illuminate\Http\Request;
use Modules\PkgEntretienIndividuel\Services\EntretienService;
use App\Http\Controllers\Controller; 

class EntretienController extends Controller
{
    protected $entretienService;

    public function __construct(EntretienService $entretienService)
    {
        $this->entretienService = $entretienService;
    }

    public function index()
    {
        $entretien = $this->entretienService->getAll();
        return response()->json([
            'message' => 'Entretien récupéré avec succès',
            'data' => $entretien
        ], 200); // 200 is more appropriate for GET
    }

    public function store(Request $request)
    {
        $entretien = $this->entretienService->create($request->all());
        return response()->json([
            'message' => 'Entretien créé avec succès',
            'data' => $entretien
        ], 201); // 201 is more appropriate for POST
    }

    public function show($id)
    {
        $entretien = $this->entretienService->find($id);
        return response()->json([
            'message' => 'Entretien récupéré avec succès',
            'data' => $entretien
        ], 200); // 200 is more appropriate for GET
    }

    public function update($id, Request $request)
    {
        $entretien = $this->entretienService->update($id, $request->all());
        return response()->json([
            'message' => 'Entretien mis à jour avec succès',
            'data' => $entretien
        ], 201); // 201 is more appropriate for PUT
    }

    public function destroy($id)
    {
        $entretien = $this->entretienService->delete($id);
        return response()->json([
            'message' => 'Entretien supprimé avec succès',
            'data' => $entretien
        ], 201); // 201 is more appropriate for DELETE
    }
    public function getUpcomingEntretiensCount ()  
    {
        $entretiens = $this->entretienService->getUpcomingEntretiensCount();
        return response()->json([
            'message' => 'Entretiens à venir récupérés avec succès',
            'data' => $entretiens
        ], 201);    
    }
    public function getInterviewCountByPromotion($promotion)
    {
        $entretiens = $this->entretienService->getInterviewCountByPromotion($promotion);
        return response()->json([
            'message' => 'Entretiens récupérés avec succès',
            'data' => $entretiens
        ], 201);    
    }
}
