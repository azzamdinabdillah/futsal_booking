<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Field;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $field = Field::first();

        if ($field) {
            $playDate = now()->addDays(3);
            
            Booking::query()->updateOrCreate(
                ['booking_code' => 'FTL-20260303-ABC1'],
                [
                    'field_id' => $field->id,
                    'customer_name' => 'John Doe',
                    'customer_whatsapp' => '081234567890',
                    'customer_email' => 'john@example.com',
                    'play_date' => $playDate->format('Y-m-d'),
                    'start_time' => '16:00:00',
                    'end_time' => '18:00:00',
                    'duration_hours' => 2.00,
                    'price_per_hour_snapshot' => $field->price_per_hour,
                    'total_price' => $field->price_per_hour * 2,
                    'payment_method' => 'dp_pay_onsite',
                    'dp_percentage_snapshot' => 30.00,
                    'dp_amount' => ($field->price_per_hour * 2) * 0.3,
                    'remaining_amount' => ($field->price_per_hour * 2) * 0.7,
                    'status' => 'waiting_payment',
                    'policy_agreed' => true,
                ]
            );

            Booking::query()->updateOrCreate(
                ['booking_code' => 'FTL-20260303-XYZ2'],
                [
                    'field_id' => $field->id,
                    'customer_name' => 'Jane Smith',
                    'customer_whatsapp' => '089876543210',
                    'customer_email' => 'jane@example.com',
                    'play_date' => $playDate->format('Y-m-d'),
                    'start_time' => '20:00:00',
                    'end_time' => '21:00:00',
                    'duration_hours' => 1.00,
                    'price_per_hour_snapshot' => $field->price_per_hour,
                    'total_price' => $field->price_per_hour,
                    'payment_method' => 'full_transfer',
                    'status' => 'confirmed',
                    'policy_agreed' => true,
                    'confirmed_at' => now(),
                ]
            );
        }
    }
}
