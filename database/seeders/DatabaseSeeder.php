<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\FieldSeeder;
use Database\Seeders\FieldPhotoSeeder;
use Database\Seeders\SystemConfigSeeder;
use Database\Seeders\BlockedSlotSeeder;
use Database\Seeders\BookingSeeder;
use Database\Seeders\NotificationSeeder;
use Database\Seeders\ReviewSeeder;

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
            FieldPhotoSeeder::class,
            SystemConfigSeeder::class,
            BlockedSlotSeeder::class,
            BookingSeeder::class,
            NotificationSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
