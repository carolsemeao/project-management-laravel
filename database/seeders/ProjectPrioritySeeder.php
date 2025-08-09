<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            'low',
            'medium',
            'high',
            'urgent'
        ];

        foreach ($priorities as $priority) {
            DB::table('project_priorities')->insertOrIgnore([
                'name' => $priority,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
} 