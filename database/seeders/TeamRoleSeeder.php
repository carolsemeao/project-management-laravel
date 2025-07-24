<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Models\TeamUser;

class TeamRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $projectManager = Role::create([
            'name' => 'Project Manager',
            'description' => 'Can manage projects, assign issues, and view reports',
            'permissions' => [
                'can_view_issues',
                'can_create_issues',
                'can_edit_issues',
                'can_assign_issues',
                'can_delete_issues',
                'can_manage_team',
                'can_view_reports',
            ],
            'status' => 'active'
        ]);

        $developer = Role::create([
            'name' => 'Developer',
            'description' => 'Can work on issues and update their status',
            'permissions' => [
                'can_view_issues',
                'can_edit_issues',
                'can_create_issues',
            ],
            'status' => 'active'
        ]);

        $uxUiDesigner = Role::create([
            'name' => 'UX/UI Designer',
            'description' => 'Can create and edit design-related issues',
            'permissions' => [
                'can_view_issues',
                'can_create_issues',
                'can_edit_issues',
            ],
            'status' => 'active'
        ]);

        // Create Teams
        $frontendTeam = Team::create([
            'name' => 'Frontend Team',
            'description' => 'Responsible for user interface and user experience',
            'color' => '#007bff',
            'status' => 'active'
        ]);

        $backendTeam = Team::create([
            'name' => 'Backend Team', 
            'description' => 'Responsible for server-side development and APIs',
            'color' => '#28a745',
            'status' => 'active'
        ]);

        $designTeam = Team::create([
            'name' => 'Design Team',
            'description' => 'Responsible for UI/UX design and user research',
            'color' => '#dc3545',
            'status' => 'active'
        ]);

        // Assign current user to teams (if exists)
        $user = User::first();
        if ($user) {
            // Make the user a Project Manager in Frontend Team
            TeamUser::create([
                'user_id' => $user->id,
                'team_id' => $frontendTeam->id,
                'role_id' => $projectManager->id,
                'status' => 'active',
                'joined_at' => now(),
            ]);

            // Also make them a Developer in Backend Team
            TeamUser::create([
                'user_id' => $user->id,
                'team_id' => $backendTeam->id,
                'role_id' => $developer->id,
                'status' => 'active',
                'joined_at' => now(),
            ]);
        }

        $this->command->info('Teams and Roles seeded successfully!');
        $this->command->info('Created 3 roles: Project Manager, Developer, UX/UI Designer');
        $this->command->info('Created 3 teams: Frontend, Backend, Design');
        if ($user) {
            $this->command->info("Assigned {$user->name} to multiple teams with different roles");
        }
    }
}
