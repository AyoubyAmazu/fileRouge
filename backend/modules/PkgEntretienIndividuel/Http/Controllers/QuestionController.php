<?php

namespace Modules\PkgEntretienIndividuel\Http\Controllers; 

use Illuminate\Http\Request;
use Modules\PkgEntretienIndividuel\Services\QuestionService;
use Http\Controllers\Controller;
use Modules\PkgEntretienIndividuel\Http\Requests\StoreQuestionRequest;
use Modules\PkgEntretienIndividuel\Http\Requests\UpdateQuestionRequest;

class QuestionController extends Controller
{
    protected $questionService;
    
    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }
    
    public function getAll()
    {
        return response()->json([
            'message' => 'Questions récupérées avec succès',
            'data' => $this->questionService->getAll()
        ], 201);
    }

    public function getById($id)
    {
        return response()->json([
            'message' => 'Question récupérée avec succès',
            'data' => $this->questionService->find($id)
        ], 201);
    }

    public function store(StoreQuestionRequest $request)
    {
        return response()->json([
            'message' => 'Question créée avec succès',
            'data' => $this->questionService->create($request->all())
        ], 201);
    }
    public function update($id, UpdateQuestionRequest $request)
    {
        return response()->json([
            'message' => 'Question mise à jour avec succès',
            'data' => $this->questionService->update($id, $request->all())
        ], 201);
    }
    public function destroy($id)
    {
        return response()->json([
            'message' => 'Question supprimée avec succès',
            'data' => $this->questionService->delete($id)
        ], 201);
    }
}