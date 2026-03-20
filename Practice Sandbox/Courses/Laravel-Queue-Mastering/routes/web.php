<?php

use App\Http\Controllers\PracticeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;

Route::get('imageProcess', function () {
    return view('image-process');
});


Route::get('wordProcess', function () {
    return view('word-process');
});


Route::get('/batch/{batchId}', function (string $batchId) {
    return Bus::findBatch($batchId);
});


Route::get('/practice', PracticeController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
