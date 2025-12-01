<?php

use Illuminate\Support\Facades\Route;
use Modules\SEO\Http\Controllers\SEOController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('seos', SEOController::class)->names('seo');
});
