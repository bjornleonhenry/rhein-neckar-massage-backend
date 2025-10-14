<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LanguageKey;
use App\Models\LanguageString;

class FooterLanguageSeeder extends Seeder
{
    public function run()
    {
        $keys = [
            [
                'key' => 'footer.title.line1',
                'type' => 'title',
                'default' => 'Rhein',
                'tags' => ['footer'],
                'en' => 'Rhein',
                'de' => 'Rhein',
            ],
            [
                'key' => 'footer.title.line2',
                'type' => 'title',
                'default' => 'Neckar',
                'tags' => ['footer'],
                'en' => 'Neckar',
                'de' => 'Neckar',
            ],
            [
                'key' => 'footer.title.line3',
                'type' => 'title',
                'default' => 'Massage',
                'tags' => ['footer'],
                'en' => 'Massage',
                'de' => 'Massage',
            ],
            [
                'key' => 'footer.address',
                'type' => 'text',
                'default' => 'WurstStraße 45, 64283 Heidenburg',
                'tags' => ['footer'],
                'en' => 'WurstStraße 45, 64283 Heidenburg',
                'de' => 'WurstStraße 45, 64283 Heidenburg',
            ],
            [
                'key' => 'footer.description',
                'type' => 'text',
                'default' => 'Your exclusive erotic massage studio in Heidenburg. Sensual relaxation in elegant, discreet atmosphere. Highest quality and absolute discretion are our priority.',
                'tags' => ['footer'],
                'en' => 'Your exclusive erotic massage studio in Heidenburg. Sensual relaxation in elegant, discreet atmosphere. Highest quality and absolute discretion are our priority.',
                'de' => 'Ihr exklusives Erotik-Massage Studio in Heidenburg. Sinnliche Entspannung in eleganter, diskreter Atmosphäre. Höchste Qualität und absolute Diskretion sind unsere Priorität.',
            ],
        ];

        foreach ($keys as $k) {
            $languageKey = LanguageKey::updateOrCreate(
                ['key' => $k['key']],
                [
                    'type' => $k['type'],
                    'default' => $k['default'],
                    'tags' => $k['tags'],
                    'is_active' => true,
                ]
            );

            // english
            LanguageString::updateOrCreate(
                ['language_key_id' => $languageKey->id, 'lang' => 'en'],
                ['value' => $k['en'], 'is_active' => true, 'string' => $languageKey->key]
            );

            // german
            LanguageString::updateOrCreate(
                ['language_key_id' => $languageKey->id, 'lang' => 'de'],
                ['value' => $k['de'], 'is_active' => true, 'string' => $languageKey->key]
            );
        }
    }
}
