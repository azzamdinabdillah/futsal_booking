<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $booking = Booking::first();

        if ($booking) {
            $notifications = [
                [
                    'booking_id' => $booking->id,
                    'type' => 'booking_created',
                    'channel' => 'whatsapp',
                    'recipient' => $booking->customer_whatsapp,
                    'status' => 'sent',
                    'sent_at' => now(),
                ],
                [
                    'booking_id' => $booking->id,
                    'type' => 'booking_created',
                    'channel' => 'email',
                    'recipient' => $booking->customer_email,
                    'status' => 'sent',
                    'sent_at' => now(),
                ],
                [
                    'booking_id' => $booking->id,
                    'type' => 'booking_confirmed',
                    'channel' => 'whatsapp',
                    'recipient' => $booking->customer_whatsapp,
                    'status' => 'pending',
                ],
            ];

            foreach ($notifications as $notification) {
                Notification::query()->create($notification);
            }
        }
    }
}
