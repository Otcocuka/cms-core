<?php

use Illuminate\Support\Facades\Route;
use Modules\Settings\Http\Controllers\SettingsController;
use Modules\Settings\Http\Livewire\Admin\SettingsTable;

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // ❗ НОВЫЙ ПОРЯДОК: Сначала конкретный маршрут
    Route::get('/settings/ui', SettingsTable::class)->name('settings.ui');

    // Потом REST API
    Route::resource('settings', SettingsController::class)->names('settings');
});
