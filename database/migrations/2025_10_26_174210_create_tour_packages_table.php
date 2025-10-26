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
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('price_unit', 20)->default('per pax'); // per pax, per group, etc.
            $table->string('duration')->nullable(); // e.g., "Full Day", "Half Day", "2 Hours"
            $table->json('includes')->nullable(); // What's included in the package
            $table->string('image_path')->nullable();
            $table->text('notes')->nullable(); // Pre-booking Required, Conditions Apply, etc.
            $table->enum('difficulty_level', ['easy', 'moderate', 'challenging'])->default('easy');
            $table->integer('min_participants')->default(1);
            $table->integer('max_participants')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
