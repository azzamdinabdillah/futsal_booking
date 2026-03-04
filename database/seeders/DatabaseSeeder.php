<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\FieldSeeder;
use Database\Seeders\SystemConfigSeeder;
use Database\Seeders\BlockedSlotSeeder;
use Database\Seeders\BookingSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            FieldSeeder::class,
            SystemConfigSeeder::class,
            BlockedSlotSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
