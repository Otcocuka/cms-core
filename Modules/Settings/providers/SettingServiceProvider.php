<?php

namespace Modules\Settings\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Settings\Services\SettingsManager;

class SettingsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SettingsManager::class);
    }

    public function provides()
    {
        return [SettingsManager::class];
    }
}
