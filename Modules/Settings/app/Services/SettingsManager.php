<?php

namespace Modules\Settings\Services;

use Modules\Settings\Models\Setting;
use Throwable;

class SettingsManager
{
    private ?array $settings = null;

    public function get(string $key, mixed $default = null): mixed
    {
        $this->loadSettingsOnce();
        return $this->settings[$key] ?? $default;
    }

    public function set(string $key, mixed $value, array $meta = []): bool
    {
        try {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => $meta['group'] ?? 'general',
                    'type' => $meta['type'] ?? gettype($value),
                    'autoload' => $meta['autoload'] ?? true,
                ]
            );

            Setting::clearCache();
            return true;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    private function loadSettingsOnce(): void
    {
        if (is_null($this->settings)) {
            $this->settings = Setting::allCached();
        }
    }

    public function clearCache(): void
    {
        Setting::clearCache();
    }
}
