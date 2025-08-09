<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'planning',
            'active',
            'on_hold',
            'completed',
            'cancelled'
        ];

        foreach ($statuses as $status) {
            DB::table('project_statuses')->insertOrIgnore([
                'name' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
} 