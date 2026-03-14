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
            // Color Palette
            [
                'key' => 'color_primary',
                'value' => '#059669', // Slate 900
                'description' => 'Warna utama aplikasi (Primary)',
            ],
            [
                'key' => 'color_secondary',
                'value' => '#64748B', // Slate 500
                'description' => 'Warna sekunder aplikasi (Secondary)',
            ],
            [
                'key' => 'color_success',
                'value' => '#10B981', // Green 500
                'description' => 'Warna indikator sukses',
            ],
            [
                'key' => 'color_danger',
                'value' => '#EF4444', // Red 500
                'description' => 'Warna indikator bahaya/error',
            ],
            [
                'key' => 'color_warning',
                'value' => '#F59E0B', // Amber 500
                'description' => 'Warna indikator peringatan',
            ],
            [
                'key' => 'color_info',
                'value' => '#0EA5E9', // Blue 500
                'description' => 'Warna indikator informasi',
            ],
            [
                'key' => 'color_light',
                'value' => '#F8FAFC', // Slate 50
                'description' => 'Warna latar terang',
            ],
            [
                'key' => 'color_dark',
                'value' => '#0F172A', // Slate 950
                'description' => 'Warna latar gelap/teks',
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
