<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Settings\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            [
                'key' => 'site_name',
                'value' => 'CMS Core',
                'group' => 'general',
                'type' => 'string',
                'autoload' => true
            ],
            [
                'key' => 'site_description',
                'value' => 'Professional CMS Platform',
                'group' => 'general',
                'type' => 'string',
                'autoload' => true
            ],
            [
                'key' => 'admin_email',
                'value' => 'admin@example.com',
                'group' => 'general',
                'type' => 'string',
                'autoload' => true
            ],
            [
                'key' => 'image_upload_max_size',
                'value' => '2048',
                'group' => 'media',
                'type' => 'integer',
                'autoload' => true
            ],
            [
                'key' => 'allowed_image_mime_types',
                'value' => '["image/jpeg","image/png","image/gif"]',
                'group' => 'media',
                'type' => 'json',
                'autoload' => true
            ],
        ];

        foreach ($defaults as $item) {
            Setting::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
