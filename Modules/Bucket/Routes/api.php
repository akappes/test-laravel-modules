<?php


use Modules\Bucket\Http\Controllers\BucketController;
use \Modules\Bucket\Http\Controllers\StorageController;

Route::prefix('buckets')->group(function () {
    Route::post('/', [BucketController::class, 'store']);
    Route::delete('/{id}', [BucketController::class, 'delete']);

    Route::prefix('storage')->group(function () {
        Route::post('/add', [StorageController::class, 'add']);
        Route::post('/remove', [StorageController::class, 'remove']);
    });
});
