<?php


use Modules\Bucket\Http\Controllers\BucketController;

Route::prefix('buckets')->group(function () {
    Route::post('/', [BucketController::class, 'store']);
    Route::delete('/{id}', [BucketController::class, 'delete']);
});
