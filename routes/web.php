<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SWStarterController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\StatisticsRegister;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/sw-starter', [SWStarterController::class, 'index'])->name('swstarter.index')->middleware(StatisticsRegister::class);
    Route::get('/sw-starter/show', [SWStarterController::class, 'show'])->name('swstarter.show');
});

require __DIR__ . '/auth.php';
