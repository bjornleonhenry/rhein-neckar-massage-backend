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
        Schema::create('ambients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('type'); // e.g., 'spa', 'lounge', 'therapy', 'wellness'
            $table->string('location');
            $table->integer('capacity');
            $table->json('features'); // Array of features like 'wifi', 'music', 'lighting'
            $table->json('amenities'); // Array of amenities
            $table->string('image')->nullable();
            $table->decimal('rating', 2, 1)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ambients');
    }
};
