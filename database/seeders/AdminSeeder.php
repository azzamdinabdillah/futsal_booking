<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::query()->updateOrCreate(
            ['username' => 'admin'],
            [
                'full_name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password_hash' => Hash::make('secret123'),
            ]
        );
    }
}
