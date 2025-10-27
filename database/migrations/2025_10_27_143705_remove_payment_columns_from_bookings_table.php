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
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'total_amount',
                'payment_status',
                'payment_reference',
                'payment_details'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('total_amount', 10, 2)->after('nights');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending')->after('total_amount');
            $table->string('payment_reference')->nullable()->after('payment_status');
            $table->json('payment_details')->nullable()->after('payment_reference');
        });
    }
};
