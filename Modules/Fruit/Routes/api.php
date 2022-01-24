<?php

use Modules\Fruit\Http\Controllers\FruitController;

Route::prefix('fruits')->group(function () {
    Route::get('/', [FruitController::class, 'index']);
    Route::post('/', [FruitController::class, 'store']);
    Route::put('/{id}', [FruitController::class, 'update']);
    Route::delete('/{id}', [FruitController::class, 'delete']);
});
