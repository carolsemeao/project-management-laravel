<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            ['name' => 'low', 'color' => '#0d6efd'],
            ['name' => 'normal', 'color' => '#0d6efd'],
            ['name' => 'high', 'color' => '#0d6efd'],
            ['name' => 'urgent', 'color' => '#0d6efd'],
            ['name' => 'immediate', 'color' => '#0d6efd'],
        ];

        foreach ($priorities as $priority) {
            DB::table('priorities')->insert([
                'name' => $priority['name'],
                'color' => $priority['color'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Priorities table seeded successfully!');
    }
}
