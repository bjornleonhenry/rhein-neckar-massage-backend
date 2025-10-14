<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mieterin;

class MieterinnenSeeder extends Seeder
{
    public function run(): void
    {
        // Get current mieterinnen from database and insert them
        $currentMieterinnen = \DB::table('mieterinnen')->get();
        
        foreach ($currentMieterinnen as $item) {
            Mieterin::updateOrCreate(
                ['id' => $item->id],
                (array) $item
            );
        }
    }
}
