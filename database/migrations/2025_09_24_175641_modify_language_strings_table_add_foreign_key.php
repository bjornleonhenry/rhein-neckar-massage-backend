<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('language_strings', function (Blueprint $table) {
            // Add foreign key to language_keys only if it doesn't exist
            if (!Schema::hasColumn('language_strings', 'language_key_id')) {
                $table->foreignId('language_key_id')->constrained('language_keys')->onDelete('cascade');
            }

            // Remove fields that are now in language_keys (only if they exist)
            if (Schema::hasColumn('language_strings', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('language_strings', 'default')) {
                $table->dropColumn('default');
            }
            if (Schema::hasColumn('language_strings', 'tags')) {
                $table->dropColumn('tags');
            }
        });
    }

    public function down(): void
    {
        Schema::table('language_strings', function (Blueprint $table) {
            // Add back the removed columns only if they don't exist
            if (!Schema::hasColumn('language_strings', 'type')) {
                $table->string('type')->default('text')->after('value');
            }
            if (!Schema::hasColumn('language_strings', 'default')) {
                $table->text('default')->nullable()->after('type');
            }
            if (!Schema::hasColumn('language_strings', 'tags')) {
                $table->json('tags')->nullable()->after('default');
            }

            // Remove the foreign key and column if they exist
            if (Schema::hasColumn('language_strings', 'language_key_id')) {
                $table->dropForeign(['language_key_id']);
                $table->dropColumn('language_key_id');
            }
        });
    }
};
