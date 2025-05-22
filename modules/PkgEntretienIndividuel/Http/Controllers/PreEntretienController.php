<?php

namespace Modules\PkgEntretienIndividuel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\PkgEntretienIndividuel\Services\PreEntretienService;
use Http\Controllers\Controller;
use Modules\PkgEntretienIndividuel\Http\Requests\StorePreEntretienRequest;
use Modules\PkgEntretienIndividuel\Http\Requests\UpdatePreEntretienRequest;

class PreEntretienController extends Controller
{
    protected $preEntretienService;

    public function __construct(PreEntretienService $preEntretienService)
    {
        $this->preEntretienService = $preEntretienService;
    }

    public function getAll()
    {
        $preEntretien = $this->preEntretienService->getAll();
        return response()->json([
            'message' => 'Pre-entretien récupéré avec succès',
            'data' => $preEntretien
        ]);
    }

    public function getById($id)
    {
        $preEntretien = $this->preEntretienService->find($id);
        return response()->json([
            'message' => 'Pre-entretien récupéré avec succès',
            'data' => $preEntretien
        ]);
    }

    public function store(StorePreEntretienRequest $request)
    {
        $preEntretien = $this->preEntretienService->create($request->all());
        return response()->json([
            'message' => 'Pre-entretien créé avec succès',
            'data' => $preEntretien
        ]);
    }

    public function update(UpdatePreEntretienRequest $request, $id)
    {
        $preEntretien = $this->preEntretienService->update($id, $request->all());
        return response()->json([
            'message' => 'Pre-entretien mis à jour avec succès',
            'data' => $preEntretien
        ]);
    }

    public function destroy($id)
    {
        $preEntretien = $this->preEntretienService->delete($id);
        return response()->json([
            'message' => 'Pre-entretien supprimé avec succès'
        ]);
    }
}
