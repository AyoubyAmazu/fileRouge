<?php

use Illuminate\Support\Facades\Route;

use Modules\PkgEntretienIndividuel\Http\Controllers\EntretienController;
use Modules\PkgEntretienIndividuel\Http\Controllers\QuestionController;
use Modules\PkgEntretienIndividuel\Http\Controllers\OptionReponseController;
use Modules\PkgEntretienIndividuel\Http\Controllers\ApprenantController;
use Modules\PkgEntretienIndividuel\Http\Controllers\PreEntretienController;
use Modules\PkgEntretienIndividuel\Http\Controllers\ReponsePreEntretienController;
use Modules\PkgEntretienIndividuel\Http\Controllers\GroupeController;





Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello Worldaaa',
        'status' => 'success',
    ], 201);
});

// Entretien routes
Route::prefix('api/entretiens')->group(function () {
    Route::get('/', [EntretienController::class, 'index']);
    Route::post('/', [EntretienController::class, 'store']);
    Route::get('/upcoming/count', [EntretienController::class, 'getUpcomingEntretiensCount']); 
    Route::get('/count/{promotion}', [EntretienController::class, 'getInterviewCountByPromotion']);
    Route::get('/{id}', [EntretienController::class, 'show']);
    Route::put('/{id}', [EntretienController::class, 'update']);
    Route::delete('/{id}', [EntretienController::class, 'destroy']);
});

// Pre-entretien routes
Route::prefix('api/pre-entretien')->group(function () {
    Route::get('/', [PreEntretienController::class, 'getAll']);
    Route::post('/', [PreEntretienController::class, 'store']);
    Route::get('/{id}', [PreEntretienController::class, 'getById']);
    Route::put('/{id}', [PreEntretienController::class, 'update']);
    Route::delete('/{id}', [PreEntretienController::class, 'destroy']);
    Route::get('/submitted/count/{promotion}', [PreEntretienController::class, 'getSubmittedPreEntretienCount']); 
    
});

// Question routes
Route::prefix('api/question')->group(function () {
    Route::get('/', [QuestionController::class, 'getAll']);
    Route::post('/', [QuestionController::class, 'store']);
    Route::get('/{id}', [QuestionController::class, 'getById']);
    Route::put('/{id}', [QuestionController::class, 'update']);
    Route::delete('/{id}', [QuestionController::class, 'destroy']);
});

// OptionReponse routes
Route::prefix('api/option_question')->group(function () {
    Route::get('/', [OptionReponseController::class, 'getAll']);
    Route::post('/', [OptionReponseController::class, 'store']);
    Route::get('/{id}', [OptionReponseController::class, 'getById']);
    Route::put('/{id}', [OptionReponseController::class, 'update']);
    Route::delete('/{id}', [OptionReponseController::class, 'destroy']);
});

// ReponsePreEntretien routes
Route::prefix('api/reponse_pre_entretien')->group(function () {
    Route::get('/', [ReponsePreEntretienController::class, 'getAll']);
    Route::post('/', [ReponsePreEntretienController::class, 'store']);
    Route::get('/{id}', [ReponsePreEntretienController::class, 'getById']);
    Route::put('/{id}', [ReponsePreEntretienController::class, 'update']);
    Route::delete('/{id}', [ReponsePreEntretienController::class, 'destroy']);
});

// Groupe routes
Route::prefix('api/groupe')->group(function () {
    Route::get('/', [GroupeController::class, 'getAllGroupes']);
});

// Apprenant routes
Route::prefix('api/apprenants/groupe')->group(function () {
    Route::get('/', [ApprenantController::class, 'getApprenantsWithGroup']);
});

// Hello route
Route::prefix('api/hello')->group(function () {
    Route::get('/', function () {
        return response()->json([
            'message' => 'Hello Worldaaa',
            'status' => 'success',
        ], 201);
    });
});
