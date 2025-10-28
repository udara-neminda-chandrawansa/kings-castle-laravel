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
        Schema::table('tour_payments', function (Blueprint $table) {
            // Drop foreign key constraint first
            if (Schema::hasColumn('tour_payments', 'tour_package_id')) {
                $table->dropForeign(['tour_package_id']);
            }
            
            // Add the new foreign key if it doesn't exist
            if (!Schema::hasColumn('tour_payments', 'tour_booking_id')) {
                $table->foreignId('tour_booking_id')->nullable()->constrained('tour_bookings')->onDelete('cascade');
            }
            
            // Drop the booking-related columns that will move to tour_bookings
            $columnsToCheck = [
                'tour_package_id',
                'guest_name',
                'guest_email', 
                'guest_phone',
                'guest_address',
                'guest_address_2',
                'participants',
                'tour_date',
                'special_requests',
                'status'
            ];
            
            $columnsToDrop = [];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('tour_payments', $column)) {
                    $columnsToDrop[] = $column;
                }
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_payments', function (Blueprint $table) {
            // Add back the dropped columns
            $table->foreignId('tour_package_id')->constrained()->onDelete('cascade');
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone');
            $table->text('guest_address');
            $table->text('guest_address_2')->nullable();
            $table->integer('participants');
            $table->date('tour_date');
            $table->text('special_requests')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            
            // Drop the foreign key
            $table->dropForeign(['tour_booking_id']);
            $table->dropColumn('tour_booking_id');
        });
    }
};
