<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use App\Models\Role;
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
        $frontendTeam = Team::where('name', 'Frontend Team')->first();
        $backendTeam = Team::where('name', 'Backend Team')->first();
        $designTeam = Team::where('name', 'Design Team')->first();
        $projectManagerRole = Role::where('name', 'Project Manager')->first();
        $developerRole = Role::where('name', 'Developer')->first();

        if (!$user || !$frontendTeam || !$backendTeam || !$designTeam) {
            $this->command->error('Required teams or users not found. Please run TeamRoleSeeder first.');
            return;
        }

        // Create Website Redesign Project
        $websiteProject = Project::create([
            'name' => 'Website Redesign',
            'description' => 'Complete overhaul of company website with modern design and improved UX',
            'start_date' => Carbon::now()->subDays(30),
            'due_date' => Carbon::now()->addDays(60),
            'status_id' => 2, // active
            'priority_id' => 3, // high
            'color' => '#007bff',
            'budget' => 50000.00,
            'created_by_user_id' => $user->id,
        ]);

        // Create Mobile App Development Project
        $mobileProject = Project::create([
            'name' => 'Mobile App Development',
            'description' => 'Native iOS and Android app for customer engagement',
            'start_date' => Carbon::now()->addDays(7),
            'due_date' => Carbon::now()->addDays(120),
            'status_id' => 1, // planning
            'priority_id' => 2, // medium
            'color' => '#28a745',
            'budget' => 75000.00,
            'created_by_user_id' => $user->id,
        ]);

        // Create Dashboard Analytics Project
        $dashboardProject = Project::create([
            'name' => 'Dashboard Analytics',
            'description' => 'Internal analytics dashboard for business intelligence',
            'start_date' => Carbon::now()->subDays(15),
            'due_date' => Carbon::now()->addDays(45),
            'status_id' => 2, // active
            'priority_id' => 4, // urgent
            'color' => '#dc3545',
            'budget' => 30000.00,
            'created_by_user_id' => $user->id,
        ]);

        $this->command->info('Created 3 projects: Website Redesign, Mobile App, Dashboard Analytics');

        // Assign teams to projects
        
        // Website Redesign: Frontend + Design teams
        $websiteProject->assignTeam($frontendTeam->id);
        $websiteProject->assignTeam($designTeam->id);
        
        // Mobile App: All teams
        $mobileProject->assignTeam($frontendTeam->id);
        $mobileProject->assignTeam($backendTeam->id);
        $mobileProject->assignTeam($designTeam->id);
        
        // Dashboard: Backend + Frontend teams
        $dashboardProject->assignTeam($backendTeam->id);
        $dashboardProject->assignTeam($frontendTeam->id);

        $this->command->info('Assigned teams to projects');

        // Assign user directly to projects with roles
        if ($projectManagerRole) {
            $websiteProject->assignUser($user->id, $projectManagerRole->id);
            $mobileProject->assignUser($user->id, $projectManagerRole->id);
            $dashboardProject->assignUser($user->id, $projectManagerRole->id);
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

        // Add foreign key constraint now that we have valid data
        try {
            DB::statement('ALTER TABLE issues ADD CONSTRAINT issues_project_id_foreign FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE');
            DB::statement('CREATE INDEX issues_project_id_issue_status_index ON issues (project_id, issue_status)');
            $this->command->info('Added foreign key constraint for issues.project_id');
        } catch (\Exception $e) {
            $this->command->warn('Foreign key constraint may already exist: ' . $e->getMessage());
        }

        // Display summary
        $this->command->info('');
        $this->command->info('Project Summary:');
        foreach (Project::all() as $project) {
            $this->command->info("- {$project->name}: {$project->issues()->count()} issues, {$project->teams()->count()} teams");
        }
    }
}
