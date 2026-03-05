<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Field;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $fields = Field::all();

        if ($fields->isEmpty()) {
            return;
        }

        // Generate bookings for the past 7 days and future 30 days
        $startDate = now()->subDays(7);
        $endDate = now()->addDays(30);

        foreach ($fields as $field) {
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                // Determine how many bookings for this day (2 to 8 for "banyak" data)
                $bookingsCount = rand(2, 8);
                $occupiedHours = [];

                for ($i = 0; $i < $bookingsCount; $i++) {
                    $attempts = 0;
                    $maxAttempts = 20;

                    while ($attempts < $maxAttempts) {
                        // Operational hours 08:00 - 23:00
                        $startHour = rand(8, 21);
                        $duration = rand(1, 2); // 1 or 2 hours

                        if ($startHour + $duration > 23) {
                            $attempts++;
                            continue;
                        }

                        // Check for overlap
                        $isOverlap = false;
                        for ($h = $startHour; $h < $startHour + $duration; $h++) {
                            if (in_array($h, $occupiedHours)) {
                                $isOverlap = true;
                                break;
                            }
                        }

                        if ($isOverlap) {
                            $attempts++;
                            continue;
                        }

                        // No overlap, book it
                        for ($h = $startHour; $h < $startHour + $duration; $h++) {
                            $occupiedHours[] = $h;
                        }

                        $startTime = sprintf('%02d:00:00', $startHour);
                        $endTime = sprintf('%02d:00:00', $startHour + $duration);

                        $playDateStr = $currentDate->format('Y-m-d');
                        $bookingCode = 'FTL-' . $currentDate->format('Ymd') . '-' . strtoupper($faker->bothify('???#'));

                        // Random status
                        $status = $faker->randomElement(['waiting_payment', 'confirmed', 'cancelled', 'completed']);

                        // Adjust status logic based on date
                        if ($currentDate->isPast()) {
                            $status = $faker->randomElement(['completed', 'cancelled', 'confirmed']);
                            // 'confirmed' in past might mean they played but status wasn't updated to completed, or just completed.
                            // Let's bias towards completed for past.
                            if ($status === 'confirmed') $status = 'completed';
                        } else {
                            // Future dates can't be completed
                            if ($status === 'completed') $status = 'confirmed';
                        }

                        $totalPrice = $field->price_per_hour * $duration;
                        $dpPercentage = 30;
                        $dpAmount = $totalPrice * ($dpPercentage / 100);
                        $remainingAmount = $totalPrice - $dpAmount;

                        $confirmedAt = ($status === 'confirmed' || $status === 'completed')
                            ? $currentDate->copy()->subHours(rand(1, 48))
                            : null;

                        // Ensure confirmed_at is not in future relative to now()
                        if ($confirmedAt && $confirmedAt->isFuture()) {
                            $confirmedAt = now();
                        }

                        Booking::create([
                            'booking_code' => $bookingCode,
                            'field_id' => $field->id,
                            'customer_name' => $faker->name,
                            'customer_whatsapp' => $faker->phoneNumber,
                            'customer_email' => $faker->email,
                            'play_date' => $playDateStr,
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                            'duration_hours' => $duration,
                            'price_per_hour_snapshot' => $field->price_per_hour,
                            'total_price' => $totalPrice,
                            'payment_method' => $faker->randomElement(['dp_pay_onsite', 'full_transfer']),
                            'dp_percentage_snapshot' => $dpPercentage,
                            'dp_amount' => $dpAmount,
                            'remaining_amount' => $remainingAmount,
                            'status' => $status,
                            'policy_agreed' => true,
                            'confirmed_at' => $confirmedAt,
                        ]);

                        break;
                    }
                }

                $currentDate->addDay();
            }
        }
    }
}
