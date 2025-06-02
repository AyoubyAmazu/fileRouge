<?php

namespace Modules\PkgSessionDeSuivi\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\PkgSessionDeSuivi\Services\StudentCheckinService;
use Illuminate\Http\Request;

class StudentCheckinController extends Controller
{
    protected $studentCheckinService;
    public function __construct(StudentCheckinService $studentCheckinService)
    {
        $this->studentCheckinService = $studentCheckinService;
    }

    public function todayStudentCheckin()
    {
        $todayCheckins = $this->studentCheckinService->todayStudentCheckin();
        return response()->json($todayCheckins);
       
    }
    public function getStudentCheckinByPeriod(Request $request)
    {
        $students = $this->studentCheckinService->getStudentCheckinByPeriod($request->promotionId);
        return response()->json($students);
    }
    public function getAll()
    {
        $students = $this->studentCheckinService->getAll();
        return response()->json($students);
    }
    public function getRecentStudentCheckins(Request $request)
    {
        $students = $this->studentCheckinService->getRecentStudentCheckins($request->promotionId);
        return response()->json($students);
    }
    public function getStudentCheckinByPeriodAvg()
    {
        $students = $this->studentCheckinService->getStudentCheckinByPeriodAvg();
        return response()->json($students);
    }

}
