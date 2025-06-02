<?php

use Illuminate\Support\Facades\Route;

use Modules\PkgSessionDeSuivi\Http\Controllers\PeriodController;
use Modules\PkgSessionDeSuivi\Http\Controllers\StudentController;
use Modules\PkgSessionDeSuivi\Http\Controllers\StudentCheckinController;
use Modules\PkgSessionDeSuivi\Http\Controllers\CheckinFormController;
use Modules\PkgSessionDeSuivi\Http\Controllers\QuestionController;
use Modules\PkgSessionDeSuivi\Http\Controllers\PromotionController;

// Period
Route::prefix('periods')->group(function () {
    Route::get('/', [PeriodController::class, 'getAll']);
    Route::get('/active', [PeriodController::class, 'activePeriods']);
});

//Student
Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'getAll']);
});

//Student checkin
Route::prefix('student-checkins')->group(function () {
    Route::get('/', [StudentCheckinController::class, 'getAll']);
    Route::get('/recent/{promotionId}', [StudentCheckinController::class, 'getRecentStudentCheckins']);
    Route::get('/today', [StudentCheckinController::class, 'todayStudentCheckin']);
    Route::get('/period/{promotionId}', [StudentCheckinController::class, 'getStudentCheckinByPeriod']);
    Route::get('/period-avg', [StudentCheckinController::class, 'getStudentCheckinByPeriodAvg']);
});

//CheckinForm
Route::prefix('checkin-forms')->group(function () {
    Route::get('/', [CheckinFormController::class, 'getAll']);
    Route::get('/{id}', [CheckinFormController::class, 'getFormById']);
    Route::delete('/delete/{id}', [CheckinFormController::class, 'deleteFormQuestions']);
    Route::post('/', [CheckinFormController::class, 'create']);
});

//Question
Route::prefix('questions')->group(function () {
    Route::get('/', [QuestionController::class, 'getAll']);
});

//Promotion
Route::prefix('promotions')->group(function () {
    Route::get('/', [PromotionController::class, 'getAll']);
});










Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello Worldaaa',
        'status' => 'success',
    ], 201);
});
