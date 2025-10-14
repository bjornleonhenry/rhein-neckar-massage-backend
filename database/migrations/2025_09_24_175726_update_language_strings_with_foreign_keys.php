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
        // Update language_strings to set language_key_id based on matching string with language_keys.key
        DB::statement('
            UPDATE language_strings
            SET language_key_id = (
                SELECT id FROM language_keys WHERE language_keys.key = language_strings.string
            )
            WHERE EXISTS (
                SELECT 1 FROM language_keys WHERE language_keys.key = language_strings.string
            )
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear the language_key_id column
        DB::table('language_strings')->update(['language_key_id' => null]);
    }
};
