<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $booking = Booking::first();
        $field = Field::first();

        if ($booking && $field) {
            Review::updateOrCreate(
                ['booking_id' => $booking->id],
                [
                    'field_id' => $field->id,
                    'field_rating_score' => 5,
                    'field_rating_comment' => 'Lapangan sangat bagus dan bersih!',
                    'service_rating_score' => 4,
                    'service_rating_comment' => 'Pelayanan ramah, tapi proses check-in agak lama.',
                ]
            );
        }
    }
}
