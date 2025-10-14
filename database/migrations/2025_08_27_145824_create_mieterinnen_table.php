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
        Schema::create('mieterinnen', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->text('description');
            $table->string('image');
            $table->json('specialties');
            $table->json('languages');
            $table->string('working_hours');
            $table->decimal('rating', 2, 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mieterinnen');
    }
};
