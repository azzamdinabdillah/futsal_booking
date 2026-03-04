<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\BlockedSlot;
use App\Models\Field;
use Illuminate\Database\Seeder;

class BlockedSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::where('username', 'admin')->first();
        $field = Field::where('name', 'Field A')->first();

        if ($admin && $field) {
            $slots = [
                [
                    'field_id' => $field->id,
                    'blocked_date' => now()->addDays(1)->format('Y-m-d'),
                    'start_time' => '10:00:00',
                    'end_time' => '12:00:00',
                    'reason' => 'Maintenance Rutin',
                    'created_by' => $admin->id,
                ],
                [
                    'field_id' => $field->id,
                    'blocked_date' => now()->addDays(2)->format('Y-m-d'),
                    'start_time' => '19:00:00',
                    'end_time' => '21:00:00',
                    'reason' => 'Acara Khusus Karyawan',
                    'created_by' => $admin->id,
                ],
            ];

            foreach ($slots as $slot) {
                BlockedSlot::query()->updateOrCreate(
                    [
                        'field_id' => $slot['field_id'],
                        'blocked_date' => $slot['blocked_date'],
                        'start_time' => $slot['start_time'],
                    ],
                    $slot
                );
            }
        }
    }
}
