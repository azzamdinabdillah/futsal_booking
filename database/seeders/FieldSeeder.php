<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    public function run(): void
    {
        Field::query()->updateOrCreate(
            ['name' => 'Field A'],
            [
                'price_per_hour' => 150000.00,
                'length_m' => 25.00,
                'width_m' => 15.00,
                'surface_type' => 'rumput sintetis gen 3',
                'roof_type' => 'indoor',
                'player_capacity' => '5v5',
                'description' => 'Lapangan standar',
                'status' => 'active',
                'inactive_reason' => null,
            ]
        );
    }
}
