<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\LanguageKey;
use App\Models\LanguageString;

class HomePageLanguageSeeder extends Seeder
{
    public function run()
    {
        // Ensure idempotency: find or create the language key
        $key = LanguageKey::firstOrCreate(
            ['key' => 'hero.description'],
            [
                'type' => 'page',
                'is_active' => true,
            ]
        );

        // Insert or update german string
        LanguageString::updateOrCreate(
            [
                'language_key_id' => $key->id,
                'lang' => 'de',
            ],
            [
                'string' => 'hero.description',
                'value' => 'Entdecken Sie sinnliche und leidenschaftliche Massagetechniken in eleganter, diskreter Atmosphäre. Unsere erfahrenen Verführerinnen verwöhnen Sie mit erotischen Behandlungen für ultimative Lust und Ekstase.',
                'is_active' => true,
            ]
        );

        // Create placeholder english string if missing
        LanguageString::firstOrCreate(
            [
                'language_key_id' => $key->id,
                'lang' => 'en',
            ],
            [
                'string' => 'hero.description',
                'value' => '',
                'is_active' => false,
            ]
        );
    }
}
