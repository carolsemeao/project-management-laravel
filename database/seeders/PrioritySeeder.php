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
            ['name' => 'low'],
            ['name' => 'normal'],
            ['name' => 'high'],
            ['name' => 'urgent'],
            ['name' => 'immediate'],
        ];

        foreach ($priorities as $priority) {
            DB::table('issue_priorities')->updateOrInsert(
                ['name' => $priority['name']],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        $this->command->info('Priorities table seeded successfully!');
    }
}
