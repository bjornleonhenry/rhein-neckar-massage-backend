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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('age');
            $table->string('nationality');
            $table->string('languages');
            $table->string('email');
            $table->string('phone');
            $table->enum('experience', ['keine', 'wenig', 'mittel', 'viel'])->nullable();
            $table->enum('availability', ['vollzeit', 'teilzeit', 'wochenende', 'flexibel'])->nullable();
            $table->json('specialties')->nullable();
            $table->text('motivation');
            $table->text('references')->nullable();
            $table->enum('status', ['pending', 'reviewing', 'interview', 'accepted', 'rejected'])->default('pending');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
