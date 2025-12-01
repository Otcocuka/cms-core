<?php

use Illuminate\Support\Facades\Route;
use Modules\SEO\Http\Controllers\SEOController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('seos', SEOController::class)->names('seo');
});
