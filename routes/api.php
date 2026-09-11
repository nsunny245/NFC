<?php

use App\Http\Controllers\Api\PosSyncController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| POS Terminal Cloud Synchronization API Routes
|--------------------------------------------------------------------------
|
| Handles bidirectional sync between standalone offline desktop POS terminals
| and the central cloud database.
|
*/

Route::prefix('pos/sync')->group(function () {
    Route::get('/health', [PosSyncController::class, 'health']);
    Route::post('/pull', [PosSyncController::class, 'pull']);
    Route::post('/push', [PosSyncController::class, 'push']);
});
