<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Skip if already populated
        if (DB::table('language_keys')->count() > 0) {
            return;
        }

        // Get unique keys from existing language_strings and insert into language_keys
        $uniqueKeys = DB::table('language_strings')
            ->select('string')
            ->distinct()
            ->get();

        foreach ($uniqueKeys as $keyData) {
            // For each unique key, get the first record to use for type/default/tags
            $firstRecord = DB::table('language_strings')
                ->where('string', $keyData->string)
                ->orderBy('created_at')
                ->first();

            DB::table('language_keys')->insert([
                'key' => $keyData->string,
                'type' => $firstRecord->type,
                'default' => $firstRecord->default,
                'tags' => $firstRecord->tags,
                'is_active' => $firstRecord->is_active,
                'created_at' => $firstRecord->created_at,
                'updated_at' => $firstRecord->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear the language_keys table
        DB::table('language_keys')->truncate();
    }
};
