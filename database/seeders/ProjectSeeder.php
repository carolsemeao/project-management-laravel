<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use App\Models\Role;
use App\Models\ProjectUser;
use App\Models\Issue;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $projectManagerRole = Role::where('name', 'Project Manager')->first();

        if (!$user) {
            $this->command->error('No users found. Please run other seeders first.');
            return;
        }

        // Create sample companies
        $acmeCorp = Company::firstOrCreate(
            ['name' => 'Acme Corporation'],
            [
                'email' => 'contact@acmecorp.com',
                'phone' => '+1-555-0123',
                'website' => 'https://acmecorp.com',
                'address' => '123 Business St',
                'city' => 'New York',
                'state' => 'NY',
                'zip' => '10001',
                'country' => 'USA',
                'status' => true,
            ]
        );

        $techStart = Company::firstOrCreate(
            ['name' => 'TechStart Inc'],
            [
                'email' => 'hello@techstart.com',
                'phone' => '+1-555-0456',
                'website' => 'https://techstart.com',
                'address' => '456 Innovation Ave',
                'city' => 'San Francisco',
                'state' => 'CA',
                'zip' => '94105',
                'country' => 'USA',
                'status' => true,
            ]
        );

        // Create contacts for companies
        $johnDoe = Customer::firstOrCreate(
            ['email' => 'john.doe@acmecorp.com'],
            [
                'name' => 'John Doe',
                'phone' => '+1-555-0124',
                'position' => 'CTO',
                'is_primary_contact' => true,
                'company_id' => $acmeCorp->id,
            ]
        );

        $janeSmith = Customer::firstOrCreate(
            ['email' => 'jane.smith@techstart.com'],
            [
                'name' => 'Jane Smith',
                'phone' => '+1-555-0457',
                'position' => 'CEO',
                'is_primary_contact' => true,
                'company_id' => $techStart->id,
            ]
        );

        $this->command->info('Created sample companies and contacts');

        // Create projects for companies
        $websiteProject = Project::create([
            'name' => 'Website Redesign',
            'description' => 'Complete overhaul of company website with modern design and improved UX',
            'start_date' => Carbon::now()->subDays(30),
            'due_date' => Carbon::now()->addDays(60),
            'status_id' => 2, // active
            'priority_id' => 3, // high
            'color' => '#007bff',
            'budget' => 50000.00,
            'company_id' => $acmeCorp->id,
            'customer_id' => $johnDoe->id, // John Doe as contact
            'created_by_user_id' => $user->id,
        ]);

        $mobileProject = Project::create([
            'name' => 'Mobile App Development',
            'description' => 'Native iOS and Android app for customer engagement',
            'start_date' => Carbon::now()->addDays(7),
            'due_date' => Carbon::now()->addDays(120),
            'status_id' => 1, // planning
            'priority_id' => 2, // medium
            'color' => '#28a745',
            'budget' => 75000.00,
            'company_id' => $techStart->id,
            'customer_id' => $janeSmith->id, // Jane Smith as contact
            'created_by_user_id' => $user->id,
        ]);

        $dashboardProject = Project::create([
            'name' => 'Dashboard Analytics',
            'description' => 'Internal analytics dashboard for business intelligence',
            'start_date' => Carbon::now()->subDays(15),
            'due_date' => Carbon::now()->addDays(45),
            'status_id' => 2, // active
            'priority_id' => 4, // urgent
            'color' => '#dc3545',
            'budget' => 30000.00,
            'company_id' => $acmeCorp->id,
            // No specific customer contact for this project
            'created_by_user_id' => $user->id,
        ]);

        $this->command->info('Created 3 projects for sample companies');

        // Assign user to projects with roles
        if ($projectManagerRole) {
            ProjectUser::create([
                'project_id' => $websiteProject->id,
                'user_id' => $user->id,
                'role_id' => $projectManagerRole->id,
                'assigned_at' => now(),
            ]);

            ProjectUser::create([
                'project_id' => $mobileProject->id,
                'user_id' => $user->id,
                'role_id' => $projectManagerRole->id,
                'assigned_at' => now(),
            ]);

            ProjectUser::create([
                'project_id' => $dashboardProject->id,
                'user_id' => $user->id,
                'role_id' => $projectManagerRole->id,
                'assigned_at' => now(),
            ]);
        }

        $this->command->info('Assigned user to projects as Project Manager');

        // Update existing issues to belong to projects
        $issues = Issue::all();
        if ($issues->count() > 0) {
            // Assign first 2 issues to Website Redesign
            $issues->take(2)->each(function ($issue) use ($websiteProject) {
                $issue->update(['project_id' => $websiteProject->id]);
            });

            // Assign next 2 issues to Mobile App
            $issues->skip(2)->take(2)->each(function ($issue) use ($mobileProject) {
                $issue->update(['project_id' => $mobileProject->id]);
            });

            // Assign remaining issues to Dashboard
            $issues->skip(4)->each(function ($issue) use ($dashboardProject) {
                $issue->update(['project_id' => $dashboardProject->id]);
            });

            $this->command->info('Assigned existing issues to projects');
        }

        // Display summary
        $this->command->info('');
        $this->command->info('Project Summary:');
        foreach (Project::all() as $project) {
            $companyName = $project->company ? $project->company->name : 'No Company';
            $contactName = $project->customer ? $project->customer->name : 'No Contact';
            $this->command->info("- {$project->name}: {$project->issues()->count()} issues, Company: {$companyName}, Contact: {$contactName}");
        }
    }
}
