<?php

use Illuminate\Support\Facades\Route;
use Modules\pkgEvenement\Controllers\CommunauteController;

Route::get('/apiTest', function () {
    return response()->json([
        'message' => 'Hello dddddWorld',
        'status' => 'success',
    ], 201);


});
Route::get("/communaute", [CommunauteController::class, 'countCommunaute'])->name('communaute.index');
