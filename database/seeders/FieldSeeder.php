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
                'description' => 'Lapangan standar dengan rumput sintetis berkualitas tinggi.',
                'status' => 'active',
                'inactive_reason' => null,
            ]
        );

        Field::query()->updateOrCreate(
            ['name' => 'Field B'],
            [
                'price_per_hour' => 120000.00,
                'length_m' => 25.00,
                'width_m' => 15.00,
                'surface_type' => 'vinyl',
                'roof_type' => 'indoor',
                'player_capacity' => '5v5',
                'description' => 'Lapangan lantai vinyl, cocok untuk permainan cepat.',
                'status' => 'active',
                'inactive_reason' => null,
            ]
        );

        Field::query()->updateOrCreate(
            ['name' => 'Field C (VIP)'],
            [
                'price_per_hour' => 200000.00,
                'length_m' => 28.00,
                'width_m' => 16.00,
                'surface_type' => 'rumput sintetis premium',
                'roof_type' => 'indoor',
                'player_capacity' => '5v5',
                'description' => 'Lapangan VIP dengan ukuran lebih luas dan rumput premium.',
                'status' => 'active',
                'inactive_reason' => null,
            ]
        );

        Field::query()->updateOrCreate(
            ['name' => 'Field D (Mini)'],
            [
                'price_per_hour' => 100000.00,
                'length_m' => 20.00,
                'width_m' => 12.00,
                'surface_type' => 'interlock',
                'roof_type' => 'semi-indoor',
                'player_capacity' => '4v4',
                'description' => 'Lapangan mini cocok untuk latihan atau 4 vs 4.',
                'status' => 'active',
                'inactive_reason' => null,
            ]
        );

        Field::query()->updateOrCreate(
            ['name' => 'Field E'],
            [
                'price_per_hour' => 135000.00,
                'length_m' => 26.00,
                'width_m' => 15.00,
                'surface_type' => 'parquette',
                'roof_type' => 'indoor',
                'player_capacity' => '5v5',
                'description' => 'Lapangan lantai kayu parket standar internasional.',
                'status' => 'maintenance',
                'inactive_reason' => 'Perbaikan lantai',
            ]
        );

        Field::query()->updateOrCreate(
            ['name' => 'Field F'],
            [
                'price_per_hour' => 140000.00,
                'length_m' => 25.00,
                'width_m' => 15.00,
                'surface_type' => 'cement',
                'roof_type' => 'outdoor',
                'player_capacity' => '5v5',
                'description' => 'Lapangan semen outdoor klasik.',
                'status' => 'active',
                'inactive_reason' => null,
            ]
        );
    }
}
