<?php

namespace Modules\PkgEntretienIndividuel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\PkgEntretienIndividuel\Services\OptionReponseService;
use Http\Controllers\Controller; 

class OptionReponseController extends Controller
{
    protected $optionReponseService;

    public function __construct(OptionReponseService $optionReponseService)
    {
        $this->optionReponseService = $optionReponseService;
    }

    public function getAll()
    {
        $optionReponse = $this->optionReponseService->getAll();
        return response()->json([
            'message' => 'OptionReponse récupéré avec succès',
            'data' => $optionReponse
        ], 200); // 200 is more appropriate for GET
    }
    public function getById($id)
    {
        $optionReponse = $this->optionReponseService->find($id);
        return response()->json([
            'message' => 'OptionReponse récupéré avec succès',
            'data' => $optionReponse
        ], 200); // 200 is more appropriate for GET
    }
    public function store(Request $request){

        $optionReponse = $this->optionReponseService->create($request->all());
        return response()->json([
            'message' => 'OptionReponse créé avec succès',
            'data' => $optionReponse
        ], 201); // 201 is more appropriate for POST
    }
    public function update($id, Request $request)
    {
        $optionReponse = $this->optionReponseService->update($id, $request->all());
        return response()->json([
            'message' => 'OptionReponse mise à jour avec succès',
            'data' => $optionReponse
        ], 201); // 201 is more appropriate for PUT
    }
    public function destroy($id)
    {
        $optionReponse = $this->optionReponseService->delete($id);
        return response()->json([
            'message' => 'OptionReponse supprimé avec succès',
            'data' => $optionReponse
        ], 201); // 201 is more appropriate for DELETE
    }
}