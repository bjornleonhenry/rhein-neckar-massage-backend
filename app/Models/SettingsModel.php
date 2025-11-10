<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'title',
        'value',
        'type',
    ];

    protected $casts = [
        // Don't cast value globally - handle type-specific casting in getSettingsData
    ];

    public $timestamps = true;

    // Declare properties to avoid deprecation warnings
    public $key;
    public $title;
    public $value;

    /**
     * Get the site settings as an array for Filament
     */
    public static function getSettingsData(): array
    {
        $settings = [
            'site_name' => 'My Site',
            'footer_text' => null,
            'maintenance_mode' => false,
            'age_confirmation' => false,
        ];

        // Load settings from database using raw query to avoid model casting issues
        $dbSettings = \Illuminate\Support\Facades\DB::table('settings')->get();
        foreach ($dbSettings as $setting) {
            // Cast value based on type column
            $value = $setting->value;
            if (isset($setting->type)) {
                switch ($setting->type) {
                    case 'boolean':
                        $value = (bool)$value || $value === '1' || $value === 'true';
                        break;
                    case 'integer':
                        $value = (int)$value;
                        break;
                    case 'json':
                        $value = json_decode($value, true);
                        break;
                    // string and others: keep as-is
                }
            }
            $settings[$setting->key] = $value;
        }

        return [
            'id' => 'site',
            'site_name' => $settings['site_name'],
            'footer_text' => $settings['footer_text'],
            'maintenance_mode' => $settings['maintenance_mode'],
            'age_confirmation' => $settings['age_confirmation'],
        ];
    }

    /**
     * Update site settings from array data
     */
    public static function updateSettings(array $data): void
    {
        foreach ($data as $key => $value) {
            $existing = self::where('key', $key)->first();

            if ($existing) {
                $existing->value = $value;
                $existing->save();
            } else {
                // Use direct database insert to avoid infinite loop
                \Illuminate\Support\Facades\DB::table('settings')->insert([
                    'key' => $key,
                    'title' => self::getSettingTitle($key),
                    'value' => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Get human-readable title for a setting key
     */
    private static function getSettingTitle(string $key): string
    {
        return match ($key) {
            'site_name' => 'Site Name',
            'footer_text' => 'Footer Text',
            'maintenance_mode' => 'Maintenance Mode',
            'age_confirmation' => 'Age Confirmation',
            default => ucfirst(str_replace('_', ' ', $key)),
        };
    }

    /**
     * Find method for Filament compatibility
     */
    public static function find($id)
    {
        if ($id === 'site') {
            return (object) self::getSettingsData();
        }

        return parent::find($id);
    }

    /**
     * Create method for Filament compatibility - use direct DB insert
     */
    public static function create(array $attributes = [])
    {
        $id = \Illuminate\Support\Facades\DB::table('settings')->insertGetId([
            'key' => $attributes['key'] ?? '',
            'title' => $attributes['title'] ?? '',
            'value' => $attributes['value'] ?? '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return self::find($id);
    }

    /**
     * Update method for Filament compatibility
     */
    public function update(array $attributes = [], array $options = [])
    {
        self::updateSettings($attributes);
        return $this;
    }

    /**
     * Magic getter - Disabled to prevent infinite loop
     */
    // public function __get($key)
    // {
    //     return $this->getAttribute($key);
    // }

    /**
     * Magic setter - Disabled to prevent infinite loop
     */
    // public function __set($key, $value)
    // {
    //     // Avoid infinite loop by directly setting the property
    //     $this->$key = $value;
    // }
}
