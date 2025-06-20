<?php

use App\Http\Controllers\JobListingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/test', function () {
    return view('welcome');
});

// Public routes
Route::get('/', [JobListingController::class, 'index'])->name('home');
Route::get('/careers/{slug}', [JobListingController::class, 'show'])->name('jobs.show');


// Admin routes (protected by auth and custom admin middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/careers', [JobListingController::class, 'adminIndex'])->name('jobs.index');
});
