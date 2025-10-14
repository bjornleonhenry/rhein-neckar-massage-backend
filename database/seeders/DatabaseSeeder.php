<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // All user data is handled by UserSeeder with real database data
        // User::factory(10)->create();

        $this->call([
            SettingsSeeder::class,
            LanguageKeySeeder::class,
            LanguageStringSeeder::class,
            UserSeeder::class,
            AngebotSeeder::class,
            MieterinnenSeeder::class,
            AmbientSeeder::class,
            GaestebuchSeeder::class,
            ProfilesSeeder::class,
            ProfileOptionsSeeder::class,
            BookingSeeder::class,
            MessageSeeder::class,
            JobApplicationSeeder::class,
            DbConfigSeeder::class,
        ]);
    }
}
