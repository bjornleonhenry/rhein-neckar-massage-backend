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
            $table->string('type')->default('text')->after('value'); // Type: text, button, label, etc.
            $table->text('default')->nullable()->after('type'); // Default value in English
            $table->json('tags')->nullable()->after('default'); // Tags for categorization
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('language_strings', function (Blueprint $table) {
            $table->dropColumn(['type', 'default', 'tags']);
        });
    }
};
