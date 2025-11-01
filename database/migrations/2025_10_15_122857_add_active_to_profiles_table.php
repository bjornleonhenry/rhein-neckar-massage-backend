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
        Schema::table('profiles', function (Blueprint $table) {
            // Add active column only if it doesn't exist
            if (!Schema::hasColumn('profiles', 'active')) {
                $table->boolean('active')->default(true)->after('profile_options');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Drop active column only if it exists
            if (Schema::hasColumn('profiles', 'active')) {
                $table->dropColumn('active');
            }
        });
    }
};
