<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all existing issues to map enum values to foreign keys
        
        // Map status enum values to status_id
        $statusMappings = [
            'waiting_for_planning' => 1,
            'planned' => 2,
            'in_progress' => 3,
            'on_hold' => 4,
            'feedback' => 5,
            'closed' => 6,
            'rejected' => 7,
            'resolved' => 8,
        ];

        foreach ($statusMappings as $enumValue => $statusId) {
            DB::table('issues')
                ->where('issue_status', $enumValue)
                ->update(['status_id' => $statusId]);
        }

        // Map priority enum values to priority_id
        $priorityMappings = [
            'low' => 1,
            'normal' => 2,
            'high' => 3,
            'urgent' => 4,
            'immediate' => 5,
        ];

        foreach ($priorityMappings as $enumValue => $priorityId) {
            DB::table('issues')
                ->where('issue_priority', $enumValue)
                ->update(['priority_id' => $priorityId]);
        }

        echo "Successfully converted enum values to foreign key relationships\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set all foreign keys back to null if we need to rollback
        DB::table('issues')->update([
            'status_id' => null,
            'priority_id' => null,
        ]);
    }
};
