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
            // Add foreign key to language_keys
            $table->foreignId('language_key_id')->constrained('language_keys')->onDelete('cascade');

            // Remove fields that are now in language_keys
            $table->dropColumn(['type', 'default', 'tags']);
        });
    }

    public function down(): void
    {
        Schema::table('language_strings', function (Blueprint $table) {
            // Add back the removed columns
            $table->string('type')->default('text')->after('value');
            $table->text('default')->nullable()->after('type');
            $table->json('tags')->nullable()->after('default');

            // Remove the foreign key
            $table->dropForeign(['language_key_id']);
            $table->dropColumn('language_key_id');
        });
    }
};
