<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Middleware\EnsureAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApplicationController::class, 'create'])->name('home');
Route::post('applications', [ApplicationController::class, 'store'])->name('applications.store');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [ApplicationController::class, 'dashboard'])
        ->middleware([EnsureAdmin::class])
        ->name('dashboard');

    Route::get('applications', [ApplicationController::class, 'index'])
        ->middleware([EnsureAdmin::class])
        ->name('applications.index');

    Route::get('applications/{application}', [ApplicationController::class, 'show'])
        ->middleware([EnsureAdmin::class])
        ->name('applications.show');
});

require __DIR__.'/auth.php';
