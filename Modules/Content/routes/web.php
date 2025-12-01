<?php

use Illuminate\Support\Facades\Route;
use Modules\Content\Http\Livewire\PageIndex;
use Modules\Content\Http\Livewire\PageForm;

// Middleware 'web' уже применён в RouteServiceProvider
// Здесь добавляем только 'auth'
Route::middleware(['auth'])->prefix('admin/content')->name('content.')->group(function () {
    Route::get('/pages', PageIndex::class)->name('pages.index');
    Route::get('/pages/create', PageForm::class)->name('pages.create');
    Route::get('/pages/{page}/edit', PageForm::class)->name('pages.edit');
});
