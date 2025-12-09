<?php

use Modules\Settings\Services\SettingsManager;
use Illuminate\Support\Facades\App;

if (!function_exists('settings')) {
    /**
     * Получить или установить настройку
     *
     * Использование:
     *  settings('site_name')              –> Получить
     *  settings(['site_name' => 'Site']) –> Установить
     *  settings('site_name', 'default')  –> Получить с fallback
     */
    function settings(mixed $key = null, mixed $default = null): mixed
    {
        /** @var SettingsManager $manager */
        static $manager = null;

        if ($manager === null) {
            $manager = App::make(SettingsManager::class);
        }

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $manager->set($k, $v);
            }

            return true;
        }

        return $manager->get($key, $default);
    }
}
