<?php

use Illuminate\Support\Facades\Route;
use Modules\Media\Http\Controllers\MediaController;

Route::middleware(['web', 'auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/media', [MediaController::class, 'index'])->name('media.index');
        Route::get('/media/create', [MediaController::class, 'create'])->name('media.create');
        Route::post('/media', [MediaController::class, 'store'])->name('media.store');
        Route::get('/media/{media}/edit', [MediaController::class, 'edit'])->name('media.edit');
        Route::put('/media/{media}', [MediaController::class, 'update'])->name('media.update');
        Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
    });
