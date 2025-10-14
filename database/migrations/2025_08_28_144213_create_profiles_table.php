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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->string('gender')->default('weiblich');
            $table->integer('height')->nullable(); // Größe in cm
            $table->string('bust_size')->nullable(); // Oberweite
            $table->string('body_type')->nullable(); // Typ
            $table->string('origin')->nullable(); // Herkunft
            $table->string('clothing_size')->nullable(); // Konfektionsgröße
            $table->integer('weight')->nullable(); // Gewicht in kg
            $table->integer('shoe_size')->nullable(); // Schuhgröße
            $table->string('intimate_area')->nullable(); // Intimbereich
            $table->string('hair')->nullable(); // Haare
            $table->string('eyes')->nullable(); // Augen
            $table->string('skin')->nullable(); // Haut
            $table->string('body_jewelry')->nullable(); // Körperschmuck
            $table->json('languages')->nullable(); // Sprachen
            $table->string('other')->nullable(); // Sonstiges
            $table->text('description')->nullable(); // Persönliche Beschreibung
            $table->string('image')->nullable();
            $table->json('intercourse_options')->nullable(); // Verkehr options
            $table->json('services_for')->nullable(); // Service für
            $table->json('services')->nullable(); // Service
            $table->json('meetings')->nullable(); // Treffen
            $table->json('massages')->nullable(); // Massagen
            $table->json('schedule')->nullable(); // Zeiten
            $table->text('additional_info')->nullable(); // Zusatz
            $table->json('profile_options')->nullable(); // Store all profile options as JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
