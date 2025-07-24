<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Issue;
use App\Models\User;
use App\Models\TimeEntry;
use Carbon\Carbon;

class TimeTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $issues = Issue::all();

        if (!$user || $issues->count() === 0) {
            $this->command->error('No user or issues found. Please run other seeders first.');
            return;
        }

        $this->command->info('Adding time tracking data...');

        // Set estimates for issues
        foreach ($issues as $index => $issue) {
            $estimates = ['4h', '8h', '2d', '1h 30m', '6h'];
            $estimate = $estimates[$index % count($estimates)];
            
            $issue->setEstimatedTime($estimate);
            $this->command->info("Set estimate of {$estimate} for issue: {$issue->issue_title}");
        }

        // Add time entries for issues
        $issue1 = $issues->first();
        if ($issue1) {
            // Add multiple time entries for first issue
            $timeEntries = [
                [
                    'time' => '1h 30m',
                    'description' => 'Initial research and planning',
                    'date' => Carbon::now()->subDays(3)
                ],
                [
                    'time' => '45m',
                    'description' => 'Setting up development environment',
                    'date' => Carbon::now()->subDays(2)
                ],
                [
                    'time' => '2h',
                    'description' => 'Implementation of core functionality',
                    'date' => Carbon::now()->subDays(1)
                ],
                [
                    'time' => '30m',
                    'description' => 'Bug fixes and testing',
                    'date' => Carbon::now()
                ]
            ];

            foreach ($timeEntries as $entry) {
                $issue1->logTime(
                    $user->id,
                    $entry['time'],
                    $entry['description'],
                    $entry['date']->toDateString()
                );
            }

            $this->command->info("Added time entries for issue: {$issue1->issue_title}");
        }

        // Add time entries for second issue (if exists)
        if ($issues->count() > 1) {
            $issue2 = $issues->skip(1)->first();
            
            $issue2->logTime($user->id, '3h', 'Design mockups and wireframes', Carbon::now()->subDays(1)->toDateString());
            $issue2->logTime($user->id, '1h 15m', 'Client feedback review', Carbon::now()->toDateString());
            
            $this->command->info("Added time entries for issue: {$issue2->issue_title}");
        }

        // Add time entries for third issue (if exists) - over estimate
        if ($issues->count() > 2) {
            $issue3 = $issues->skip(2)->first();
            
            // This will be over the estimate to test the UI
            $issue3->logTime($user->id, '4h', 'Complex refactoring work', Carbon::now()->subDays(2)->toDateString());
            $issue3->logTime($user->id, '2h 30m', 'Additional debugging', Carbon::now()->subDays(1)->toDateString());
            $issue3->logTime($user->id, '1h', 'Final testing', Carbon::now()->toDateString());
            
            $this->command->info("Added time entries for issue: {$issue3->issue_title} (over estimate)");
        }

        // Display summary
        $this->command->info('');
        $this->command->info('Time Tracking Summary:');
        foreach ($issues as $issue) {
            $issue->refresh();
            $estimated = $issue->formatted_estimated_time ?: 'No estimate';
            $logged = $issue->formatted_logged_time ?: '0m';
            $percentage = $issue->getTimeProgressPercentage();
            $status = $issue->getTimeTrackingStatus();
            
            $this->command->info("- {$issue->issue_title}:");
            $this->command->info("  Estimated: {$estimated} | Logged: {$logged} | Progress: {$percentage}% ({$status['message']})");
        }

        $this->command->info('');
        $this->command->info('Time tracking data seeded successfully!');
    }
}
