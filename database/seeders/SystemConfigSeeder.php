<?php

namespace Database\Seeders;

use App\Models\SystemConfig;
use Illuminate\Database\Seeder;

class SystemConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = [
            [
                'key' => 'business_name',
                'value' => 'Futsal Booking Pro',
                'description' => 'Nama bisnis / aplikasi',
            ],
            [
                'key' => 'dp_percentage',
                'value' => '30',
                'description' => 'Persentase uang muka (DP) dari total harga',
            ],
            [
                'key' => 'open_hour',
                'value' => '08:00',
                'description' => 'Jam operasional buka',
            ],
            [
                'key' => 'close_hour',
                'value' => '23:00',
                'description' => 'Jam operasional tutup',
            ],
            [
                'key' => 'bank_name',
                'value' => 'BCA',
                'description' => 'Nama bank untuk pembayaran',
            ],
            [
                'key' => 'account_number',
                'value' => '1234567890',
                'description' => 'Nomor rekening bank',
            ],
            [
                'key' => 'account_holder_name',
                'value' => 'PT Futsal Indonesia',
                'description' => 'Nama pemilik rekening',
            ],
        ];

        foreach ($configs as $config) {
            SystemConfig::query()->updateOrCreate(
                ['key' => $config['key']],
                $config
            );
        }
    }
}
