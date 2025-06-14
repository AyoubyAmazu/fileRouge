<?php

use Illuminate\Support\Facades\Route;
use Modules\pkgEvenement\Controllers\CommunauteController;
use Modules\pkgEvenement\Controllers\CommunauteMembersController;
use Modules\pkgEvenement\Controllers\EventController;

Route::get('/apiTest', function () {
    return response()->json([
        'message' => 'Hello dddddWorld',
        'status' => 'success',
    ], 201);
});


Route::controller( CommunauteController::class)->group(function () {
    Route::get("/communaute/count", 'countCommunaute')->name('communaute.count');
    Route::get('/communautes', 'index')->name('communaute.index');
    Route::get('/communauteYears', 'getYears')->name('communaute.years');
});


Route::controller(CommunauteMembersController::class)->group(function () {
    Route::get('/countMembers', 'totalMembers')->name('communaute.members.index');
    Route::get('/communauteMembers', 'index')->name('communaute.members.show');
    route::get('/communauteMembers/{id}', 'memberOfCommunaute')->name('communaute.members.of');
});


Route::controller(EventController::class)->group(function () {
    Route::get('/EventCount', 'countEvent');
    Route::get('/EventList', 'index');
    Route::get('/EventYears', 'getYears')->name('event.years');
    Route::get('/Event/{id}', 'find')->name('event.find');
    Route::post('/EventCreat', 'store')->name('event.store');
    Route::put('/EventUpdate/{id}', 'update')->name('event.update');
    Route::delete('/EventDelete/{id}', 'destroy')->name('event.destroy');
});
