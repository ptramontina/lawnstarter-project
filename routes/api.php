<?php

use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

/**
 * This will be a public route to check the statistics
 */
Route::get('/sw-starter/statistics', [StatisticsController::class, 'apiIndex']);
