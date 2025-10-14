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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('girl'); // Masseurin name
            $table->string('service');
            $table->date('date');
            $table->time('time');
            $table->string('name'); // Customer name
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->text('special_requests')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->boolean('is_read')->default(false);
            $table->decimal('price', 8, 2)->nullable();
            $table->string('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
