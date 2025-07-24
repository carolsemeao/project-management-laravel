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
        // Create Roles (or get existing ones)
        $projectManager = Role::firstOrCreate(
            ['name' => 'Project Manager'],
            [
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
            ]
        );

        $developer = Role::firstOrCreate(
            ['name' => 'Developer'],
            [
            'description' => 'Can work on issues and update their status',
            'permissions' => [
                'can_view_issues',
                'can_edit_issues',
                'can_create_issues',
            ],
            'status' => 'active'
            ]
        );

        $uxUiDesigner = Role::firstOrCreate(
            ['name' => 'UX/UI Designer'],
            [
            'description' => 'Can create and edit design-related issues',
            'permissions' => [
                'can_view_issues',
                'can_create_issues',
                'can_edit_issues',
            ],
            'status' => 'active'
            ]
        );

        // Create Teams (or get existing ones)
        $frontendTeam = Team::firstOrCreate(
            ['name' => 'Frontend Team'],
            [
            'description' => 'Responsible for user interface and user experience',
            'color' => '#007bff',
            'status' => 'active'
            ]
        );

        $backendTeam = Team::firstOrCreate(
            ['name' => 'Backend Team'],
            [
            'description' => 'Responsible for server-side development and APIs',
            'color' => '#28a745',
            'status' => 'active'
            ]
        );

        $designTeam = Team::firstOrCreate(
            ['name' => 'Design Team'],
            [
            'description' => 'Responsible for UI/UX design and user research',
            'color' => '#dc3545',
            'status' => 'active'
            ]
        );

        // Create a test user if none exists
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }
        
        // Assign user to teams (or get existing assignments)
        TeamUser::firstOrCreate(
            ['user_id' => $user->id, 'team_id' => $frontendTeam->id],
            [
                'role_id' => $projectManager->id,
                'status' => 'active',
                'joined_at' => now(),
            ]
        );

        TeamUser::firstOrCreate(
            ['user_id' => $user->id, 'team_id' => $backendTeam->id],
            [
                'role_id' => $developer->id,
                'status' => 'active',
                'joined_at' => now(),
            ]
        );

        $this->command->info('Teams and Roles seeded successfully!');
        $this->command->info('Created 3 roles: Project Manager, Developer, UX/UI Designer');
        $this->command->info('Created 3 teams: Frontend, Backend, Design');
        if ($user) {
            $this->command->info("Assigned {$user->name} to multiple teams with different roles");
        }
    }
}
