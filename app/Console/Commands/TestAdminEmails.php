<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TourBooking;
use App\Models\Booking;
use App\Mail\AdminTourBookingNotification;
use App\Mail\AdminRoomBookingNotification;
use Illuminate\Support\Facades\Mail;

class TestAdminEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:admin-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test admin notification emails for bookings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Admin Notification Emails...');

        // Test Tour Booking Admin Email
        $this->info('1. Testing Tour Booking Admin Email...');
        $latestTourBooking = TourBooking::with(['tourPackage', 'tourPayment'])->latest()->first();

        if ($latestTourBooking) {
            try {
                Mail::to('reservation@kingcastle.com')->send(new AdminTourBookingNotification($latestTourBooking));
                $this->info('✅ Tour booking admin email sent successfully!');
            } catch (\Exception $e) {
                $this->error('❌ Failed to send tour booking admin email: ' . $e->getMessage());
            }
        } else {
            $this->warn('⚠️ No tour bookings found to test with.');
        }

        // Test Room Booking Admin Email
        $this->info('2. Testing Room Booking Admin Email...');
        $latestRoomBooking = Booking::with(['roomTypes', 'payment'])->latest()->first();

        if ($latestRoomBooking) {
            try {
                Mail::to('reservation@kingcastle.com')->send(new AdminRoomBookingNotification($latestRoomBooking));
                $this->info('✅ Room booking admin email sent successfully!');
            } catch (\Exception $e) {
                $this->error('❌ Failed to send room booking admin email: ' . $e->getMessage());
            }
        } else {
            $this->warn('⚠️ No room bookings found to test with.');
        }

        $this->info('Email testing completed!');
        return 0;
    }
}
