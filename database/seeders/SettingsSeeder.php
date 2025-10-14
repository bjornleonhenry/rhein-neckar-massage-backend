<?php

namespace Database\Seeders;

use App\Settings\SiteSettings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_name',
                'title' => 'Site Name',
                'value' => 'My Site',
                'type' => 'string',
                'is_active' => true,
            ],
            [
                'key' => 'footer_text',
                'title' => 'Footer Text',
                'value' => '© 2024 My Site. All rights reserved.',
                'type' => 'text',
                'is_active' => true,
            ],
            [
                'key' => 'maintenance_mode',
                'title' => 'Maintenance Mode',
                'value' => false,
                'type' => 'boolean',
                'is_active' => true,
            ],
            [
                'key' => 'age_confirmation',
                'title' => 'Age Confirmation',
                'value' => false,
                'type' => 'boolean',
                'is_active' => true,
            ],
        ];

        foreach ($settings as $setting) {
            \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                [
                    'title' => $setting['title'],
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'is_active' => $setting['is_active'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Site settings have been seeded successfully!');
        $this->command->info('You can now manage these settings through the Filament admin panel.');
    }
}
