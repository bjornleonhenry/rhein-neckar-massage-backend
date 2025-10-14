<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ambient;

class AmbientSeeder extends Seeder
{
    public function run(): void
    {
        // Complete snapshot of all ambients (as of September 25, 2025)
        $ambients = include __DIR__ . '/../../ambients_array.php';

        foreach ($ambients as $ambientData) {
            \App\Models\Ambient::updateOrCreate(
                ['id' => $ambientData['id']],
                $ambientData
            );
        }
    }
}
