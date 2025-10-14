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
        Schema::table('settings', function (Blueprint $table) {
            $table->enum('type', ['string', 'boolean', 'number', 'text', 'json'])
                  ->default('string')
                  ->after('value');
            $table->boolean('is_active')
                  ->default(true)
                  ->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['type', 'is_active']);
        });
    }
};
