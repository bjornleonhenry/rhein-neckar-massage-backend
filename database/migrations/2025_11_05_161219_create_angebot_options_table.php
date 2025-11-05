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
        Schema::create('angebot_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('angebot_id')->constrained('angebots')->onDelete('cascade');
            $table->string('title')->nullable(); // Optional title for the option (e.g., "60 Min", "90 Min")
            $table->decimal('angebot_price', 8, 2); // Price with 2 decimal places
            $table->integer('angebot_time'); // Time in minutes
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angebot_options');
    }
};
