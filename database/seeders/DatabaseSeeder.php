<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run seeders in the correct order to handle dependencies
        $this->call([
            ProjectStatusSeeder::class,  // Creates project statuses first
            ProjectPrioritySeeder::class, // Creates project priorities first
            TeamRoleSeeder::class,      // Creates teams and roles first
            ProjectSeeder::class,       // Creates projects and assigns teams
            IssueSeeder::class,         // Creates issues and assigns to projects
            TimeTrackingSeeder::class,  // Adds time tracking data to issues
            OfferSystemSeeder::class,   // Creates offers, customers, companies
        ]);
    }
}
