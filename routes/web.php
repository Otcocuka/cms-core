<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Modules\Content\Http\Livewire\PageShow;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// ========================================================
// ДИНАМИЧЕСКИЙ РОУТ для страниц (ДОЛЖЕН БЫТЬ В САМОМ КОНЦЕ!)
// ========================================================
// Стало (временно для теста):
Route::get('/{slug}', PageShow::class)->name('page.show');
