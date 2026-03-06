<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\FieldPhoto;
use Illuminate\Database\Seeder;

class FieldPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = Field::all();

        if ($fields->isEmpty()) {
            return;
        }

        // Available photos from public/assets/images/futsal-1.jpg to futsal-14.jpg
        $availablePhotos = [];
        for ($i = 1; $i <= 14; $i++) {
            $availablePhotos[] = "assets/images/futsal-{$i}.jpg";
        }

        foreach ($fields as $field) {
            // Randomly pick 2-3 photos for each field
            $numPhotos = rand(2, 3);
            $selectedPhotos = collect($availablePhotos)->random($numPhotos);

            foreach ($selectedPhotos as $index => $photoUrl) {
                FieldPhoto::create([
                    'field_id' => $field->id,
                    'photo_url' => $photoUrl,
                    'sort_order' => $index,
                    'created_at' => now(),
                ]);
            }
        }
    }
}
