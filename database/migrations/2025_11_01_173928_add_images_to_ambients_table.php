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
        Schema::table('ambients', function (Blueprint $table) {
            // Add images column only if it doesn't exist
            if (!Schema::hasColumn('ambients', 'images')) {
                $table->json('images')->nullable()->after('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ambients', function (Blueprint $table) {
            // Drop images column only if it exists
            if (Schema::hasColumn('ambients', 'images')) {
                $table->dropColumn('images');
            }
        });
    }
};
