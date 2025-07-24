<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use App\Models\Status;
use App\Models\Priority;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating sample issues...');

        // Get the first user and projects
        $user = User::first();
        $projects = Project::all();
        $statuses = Status::all();
        $priorities = Priority::all();

        if (!$user) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        if ($projects->count() < 3) {
            $this->command->error('Not enough projects found. Please run ProjectSeeder first.');
            return;
        }

        $websiteProject = $projects->where('name', 'Website Redesign')->first();
        $mobileProject = $projects->where('name', 'Mobile App Development')->first();
        $dashboardProject = $projects->where('name', 'Dashboard Analytics')->first();

        // Get the statuses
        $closedStatus = $statuses->where('name', 'closed')->first();
        $inProgressStatus = $statuses->where('name', 'in_progress')->first();
        $plannedStatus = $statuses->where('name', 'planned')->first();
        $waitingForPlanningStatus = $statuses->where('name', 'waiting_for_planning')->first();
        $feedbackStatus = $statuses->where('name', 'feedback')->first();
        $rejectedStatus = $statuses->where('name', 'rejected')->first();
        $resolvedStatus = $statuses->where('name', 'resolved')->first();

        // Get the priorities
        $lowPriority = $priorities->where('name', 'low')->first();
        $normalPriority = $priorities->where('name', 'normal')->first();
        $highPriority = $priorities->where('name', 'high')->first();
        $urgentPriority = $priorities->where('name', 'urgent')->first();
        $immediatePriority = $priorities->where('name', 'immediate')->first();

        // Define realistic issues for each project
        $issues = [
            // Website Redesign Project Issues
            [
                'issue_title' => 'Design new homepage layout',
                'issue_description' => 'Create a modern, responsive homepage design that showcases our services and improves user engagement. Include hero section, service cards, and call-to-action buttons.',
                'status_id' => $inProgressStatus->id,
                'priority_id' => $highPriority->id,
                'issue_due_date' => Carbon::now()->addDays(10),
                'estimated_time_minutes' => 480, // 8 hours
                'project_id' => $websiteProject->id,
                'assigned_to_user_id' => $user->id,
                'created_by_user_id' => $user->id,
            ],
            [
                'issue_title' => 'Implement contact form validation',
                'issue_description' => 'Add client-side and server-side validation for the contact form. Include email validation, required field checks, and spam protection.',
                'status_id' => $plannedStatus->id,
                'priority_id' => $normalPriority->id,
                'issue_due_date' => Carbon::now()->addDays(15),
                'estimated_time_minutes' => 240, // 4 hours
                'project_id' => $websiteProject->id,
                'assigned_to_user_id' => $user->id,
                'created_by_user_id' => $user->id,
            ],
            [
                'issue_title' => 'Optimize website performance',
                'issue_description' => 'Improve page load times by optimizing images, minifying CSS/JS, and implementing caching strategies. Target PageSpeed score above 90.',
                'status_id' => $waitingForPlanningStatus->id,
                'priority_id' => $normalPriority->id,
                'issue_due_date' => Carbon::now()->addDays(20),
                'estimated_time_minutes' => 360, // 6 hours
                'project_id' => $websiteProject->id,
                'assigned_to_user_id' => $user->id,
                'created_by_user_id' => $user->id,
            ],

            // Mobile App Development Project Issues
            [
                'issue_title' => 'Set up React Native project structure',
                'issue_description' => 'Initialize new React Native project with proper folder structure, navigation, state management, and development tools configuration.',
                'status_id' => $closedStatus->id,
                'priority_id' => $urgentPriority->id,
                'issue_due_date' => Carbon::now()->subDays(5),
                'estimated_time_minutes' => 600, // 10 hours
                'project_id' => $mobileProject->id,
                'assigned_to_user_id' => $user->id,
                'created_by_user_id' => $user->id,
            ],
            [
                'issue_title' => 'Design user authentication flow',
                'issue_description' => 'Create wireframes and mockups for login, registration, password reset, and profile management screens. Include social login options.',
                'status_id' => $inProgressStatus->id,
                'priority_id' => $highPriority->id,
                'issue_due_date' => Carbon::now()->addDays(8),
                'estimated_time_minutes' => 720, // 12 hours
                'project_id' => $mobileProject->id,
                'assigned_to_user_id' => $user->id,
                'created_by_user_id' => $user->id,
            ],
            [
                'issue_title' => 'Implement push notifications',
                'issue_description' => 'Set up Firebase Cloud Messaging for both iOS and Android. Include notification scheduling, deep linking, and user preference management.',
                'status_id' => $plannedStatus->id,
                'priority_id' => $normalPriority->id,
                'issue_due_date' => Carbon::now()->addDays(25),
                'estimated_time_minutes' => 960, // 16 hours
                'project_id' => $mobileProject->id,
                'assigned_to_user_id' => $user->id,
                'created_by_user_id' => $user->id,
            ],
            [
                'issue_title' => 'Add offline data synchronization',
                'issue_description' => 'Implement offline capabilities with data sync when connection is restored. Handle conflicts and ensure data integrity.',
                'status_id' => $waitingForPlanningStatus->id,
                'priority_id' => $lowPriority->id,
                'issue_due_date' => Carbon::now()->addDays(35),
                'estimated_time_minutes' => 1440, // 24 hours
                'project_id' => $mobileProject->id,
                'assigned_to_user_id' => $user->id,
                'created_by_user_id' => $user->id,
            ],

            // Dashboard Analytics Project Issues
            [
                'issue_title' => 'Create real-time data visualization charts',
                'issue_description' => 'Implement interactive charts using Chart.js for displaying business metrics, user engagement, and sales data in real-time.',
                'status_id' => $inProgressStatus->id,
                'priority_id' => $urgentPriority->id,
                'issue_due_date' => Carbon::now()->addDays(7),
                'estimated_time_minutes' => 480, // 8 hours
                'project_id' => $dashboardProject->id,
                'assigned_to_user_id' => $user->id,
                'created_by_user_id' => $user->id,
            ],
            [
                'issue_title' => 'Set up data export functionality',
                'issue_description' => 'Allow users to export dashboard data in multiple formats (CSV, Excel, PDF). Include filtering options and custom date ranges.',
                'status_id' => $feedbackStatus->id,
                'priority_id' => $normalPriority->id,
                'issue_due_date' => Carbon::now()->addDays(12),
                'estimated_time_minutes' => 360, // 6 hours
                'project_id' => $dashboardProject->id,
                'assigned_to_user_id' => $user->id,
                'created_by_user_id' => $user->id,
            ],
            [
                'issue_title' => 'Implement user role-based access control',
                'issue_description' => 'Create admin, manager, and viewer roles with different dashboard permissions. Restrict sensitive data based on user roles.',
                'status_id' => $rejectedStatus->id,
                'priority_id' => $highPriority->id,
                'issue_due_date' => Carbon::now()->addDays(18),
                'estimated_time_minutes' => 540, // 9 hours
                'project_id' => $dashboardProject->id,
                'assigned_to_user_id' => $user->id,
                'created_by_user_id' => $user->id,
            ],
        ];

        // Create all issues
        foreach ($issues as $index => $issueData) {
            $issue = Issue::create($issueData);
            $this->command->info("Created issue #{$issue->id}: {$issue->issue_title}");
        }

        $this->command->info('');
        $this->command->info('Issues Distribution Summary:');
        foreach ($projects as $project) {
            $count = $project->issues()->count();
            $this->command->info("- {$project->name}: {$count} issues");
        }

        $this->command->info('');
        $this->command->info('Issues by Status:');
        $statusCounts = DB::table('issues')
        ->join('status', 'issues.status_id', '=', 'status.id')
        ->select('status.name as status_name', DB::raw('COUNT(*) as count'))
        ->groupBy('status.id', 'status.name')
        ->pluck('count', 'status_name');
        
        foreach ($statusCounts as $status => $count) {
            $this->command->info("- {$status}: {$count} issues");
        }

        $this->command->info('');
        $this->command->info('Sample issues created successfully!');
    }
}
