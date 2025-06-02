<?php

namespace Modules\PkgSessionDeSuivi\Http\Controllers;

use App\Http\Controllers\Controller;   
use Modules\PkgSessionDeSuivi\Services\CheckinFormService;
use Modules\PkgSessionDeSuivi\Http\Requests\CheckinFormRequest;

class CheckinFormController extends Controller
{
    protected $checkinFormService;
    public function __construct(CheckinFormService $checkinFormService)
    {
        $this->checkinFormService = $checkinFormService;
    }
    public function getAll()
    {
        return $this->checkinFormService->getAll();
    }
    public function create(CheckinFormRequest $request)
    {
        $data = $request->validated();
        $created = $this->checkinFormService->createFormWithQuestions($data);
        return response()->json($created, 201);
    }

    public function getFormById($id){
        $formId = $this->checkinFormService->getFormById($id);
        return response()->json($formId,201) ;
    }
    public function deleteFormQuestions($id){
        $formId = $this->checkinFormService->deleteFormQuestions($id);
        return response()->json($formId,201) ;
    }
}
