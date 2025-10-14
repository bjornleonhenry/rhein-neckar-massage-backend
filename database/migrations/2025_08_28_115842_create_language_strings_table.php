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
        Schema::create('language_strings', function (Blueprint $table) {
            $table->id();
            $table->string('lang', 10)->index(); // Language code (e.g., 'en', 'de', 'fr')
            $table->string('string')->index(); // Translation key/identifier
            $table->text('value'); // Translated text value
            $table->boolean('is_active')->default(true); // Whether this translation is active
            $table->timestamps(); // This adds created_at and updated_at
            
            // Add composite index for better performance
            $table->index(['lang', 'string']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language_strings');
    }
};
