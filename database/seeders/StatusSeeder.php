<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'waiting_for_planning'],
            ['name' => 'planned'],
            ['name' => 'in_progress'],
            ['name' => 'on_hold'],
            ['name' => 'feedback'],
            ['name' => 'closed'],
            ['name' => 'rejected'],
            ['name' => 'resolved'],
        ];

        foreach ($statuses as $status) {
            DB::table('issue_status')->updateOrInsert(
                ['name' => $status['name']],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        $this->command->info('Status table seeded successfully!');
    }
}
