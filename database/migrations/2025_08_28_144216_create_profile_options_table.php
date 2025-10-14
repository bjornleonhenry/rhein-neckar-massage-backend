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
        Schema::create('profile_options', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // e.g., 'gender', 'body_type', 'services', 'massages', etc.
            $table->string('option_key'); // e.g., 'weiblich', 'latina', 'body-to-body-massage'
            $table->string('option_value'); // Display value in German
            $table->string('option_value_en')->nullable(); // English translation if needed
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['category', 'option_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_options');
    }
};
