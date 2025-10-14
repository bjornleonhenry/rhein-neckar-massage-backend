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
        Schema::create('language_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->index(); // Unique translation key/identifier
            $table->string('type')->default('text'); // Type: text, button, label, etc.
            $table->text('default')->nullable(); // Default value in English
            $table->json('tags')->nullable(); // Tags for categorization
            $table->boolean('is_active')->default(true); // Whether this key is active
            $table->timestamps(); // This adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language_keys');
    }
};
