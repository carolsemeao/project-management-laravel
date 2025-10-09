<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
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
                'can_manage_projects',
                'can_view_reports',
            ],
            'status' => true
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
            'status' => true
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
            'status' => true
            ]
        );

        $this->command->info('Roles seeded successfully!');
        $this->command->info('Created 3 roles: Project Manager, Developer, UX/UI Designer');
    }
}
