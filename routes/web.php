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
    Route::get('/careers/create', [JobListingController::class, 'create'])->name('jobs.create');
    Route::post('/careers', [JobListingController::class, 'store'])->name('jobs.store');
    Route::get('/careers/{slug}/edit', [JobListingController::class, 'edit'])->name('jobs.edit');
    Route::put('/careers/{slug}', [JobListingController::class, 'update'])->name('jobs.update');
    Route::delete('/careers/{slug}', [JobListingController::class, 'destroy'])->name('jobs.destroy');
    Route::patch('/careers/{slug}/toggle', [JobListingController::class, 'toggleStatus'])->name('jobs.toggle');
});
