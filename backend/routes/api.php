<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\PkgApprenant\Controllers\ApprenantController;
use Modules\PkgEvenement\Controllers\InscriptionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/hellowa', function () {
    return response()->json([
        'message' => 'Hello Worldaaa',
        'status' => 'success',
    ], 201);
});


Route::controller(ApprenantController::class)->group(function () {
    Route::get('/apprenants_communautes', 'getMember')->name('apprenant.communautes');
    Route::post('/apprenants_communautes/update', 'updateCommunity')->name('apprenant.update.communautes');
    Route::get('/apprenants', 'getAll')->name('apprenant.all');
    Route::get('/apprenants/no_community', 'apprenantWithNoCommunity')->name('apprenant.no_community');
    Route::post('/apprenants_communautes/add', 'addCommunuates')->name('apprenant.add.communautes');
    Route::get('/totalMembers', 'totalMembers')->name('apprenant.total_members');
});



