<?php

use App\Http\Controllers\Api\GpsController;
use App\Http\Middleware\VerifyGpsApiKey;
use Illuminate\Support\Facades\Route;

// Served under /api (see bootstrap/app.php), so this is POST /api/v1/gps
Route::prefix('v1')->middleware(VerifyGpsApiKey::class)->group(function () {
    Route::post('/gps', [GpsController::class, 'store'])->name('api.gps.store');
});
