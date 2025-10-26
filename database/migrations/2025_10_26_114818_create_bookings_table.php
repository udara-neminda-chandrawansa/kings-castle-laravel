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
            $table->string('booking_reference')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade');
            
            // Guest information
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone');
            $table->integer('adults');
            $table->integer('children')->default(0);
            
            // Booking details
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('nights');
            $table->decimal('total_amount', 10, 2);
            
            // Status tracking
            $table->enum('status', ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'])->default('pending');
            
            // Payment information
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('payment_reference')->nullable();
            $table->json('payment_details')->nullable();
            
            // Special requests
            $table->text('special_requests')->nullable();
            
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
