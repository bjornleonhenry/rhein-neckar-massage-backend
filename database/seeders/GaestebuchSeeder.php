<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gaestebuch;

class GaestebuchSeeder extends Seeder
{
    public function run(): void
    {
        // Complete snapshot of all gaestebuchs (as of September 25, 2025)
        $gaestebuchs = include __DIR__ . '/../../gaestebuchs_array.php';

        foreach ($gaestebuchs as $gaestebuchData) {
            \App\Models\Gaestebuch::updateOrCreate(
                ['id' => $gaestebuchData['id']],
                $gaestebuchData
            );
                }
    }
}