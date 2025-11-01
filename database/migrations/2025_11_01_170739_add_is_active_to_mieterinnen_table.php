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
        Schema::table('mieterinnen', function (Blueprint $table) {
            // Add is_active column only if it doesn't exist
            if (!Schema::hasColumn('mieterinnen', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('rating');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mieterinnen', function (Blueprint $table) {
            // Drop is_active column only if it exists
            if (Schema::hasColumn('mieterinnen', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
