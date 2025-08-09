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
        // Check if the foreign key columns already exist
        if (!Schema::hasColumn('projects', 'status_id')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->foreignId('status_id')->nullable()->constrained('project_statuses')->onDelete('set null');
            });
        }

        if (!Schema::hasColumn('projects', 'priority_id')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->foreignId('priority_id')->nullable()->constrained('project_priorities')->onDelete('set null');
            });
        }

        // Check if the old enum columns still exist before trying to migrate data
        if (Schema::hasColumn('projects', 'status') && Schema::hasColumn('projects', 'priority')) {
            // Migrate existing enum data to foreign keys
            $this->migrateStatusData();
            $this->migratePriorityData();

            // Drop the old enum columns
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn(['status', 'priority']);
            });
        }

        // Add foreign key constraints if they don't exist
        if (!DB::select("SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'projects' AND CONSTRAINT_NAME = 'projects_status_id_foreign'")) {
            Schema::table('projects', function (Blueprint $table) {
                $table->foreign('status_id')->references('id')->on('project_statuses');
            });
        }

        if (!DB::select("SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'projects' AND CONSTRAINT_NAME = 'projects_priority_id_foreign'")) {
            Schema::table('projects', function (Blueprint $table) {
                $table->foreign('priority_id')->references('id')->on('project_priorities');
            });
        }

        // Set default values for existing records
        DB::table('projects')->whereNull('status_id')->update(['status_id' => 1]); // planning
        DB::table('projects')->whereNull('priority_id')->update(['priority_id' => 2]); // medium

        // Make columns not nullable
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->nullable(false)->change();
            $table->unsignedBigInteger('priority_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the enum columns
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('status', ['planning', 'active', 'on_hold', 'completed', 'cancelled'])->default('planning');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
        });

        // Migrate data back to enum columns
        $this->migrateDataBackToEnums();

        // Drop the foreign key columns
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropForeign(['priority_id']);
            $table->dropColumn(['status_id', 'priority_id']);
        });
    }

    /**
     * Migrate status enum values to foreign keys
     */
    private function migrateStatusData(): void
    {
        $statusMappings = [
            'planning' => 1,
            'active' => 2,
            'on_hold' => 3,
            'completed' => 4,
            'cancelled' => 5,
        ];

        foreach ($statusMappings as $enumValue => $statusId) {
            DB::table('projects')
                ->where('status', $enumValue)
                ->update(['status_id' => $statusId]);
        }
    }

    /**
     * Migrate priority enum values to foreign keys
     */
    private function migratePriorityData(): void
    {
        $priorityMappings = [
            'low' => 1,
            'medium' => 2,
            'high' => 3,
            'urgent' => 4,
        ];

        foreach ($priorityMappings as $enumValue => $priorityId) {
            DB::table('projects')
                ->where('priority', $enumValue)
                ->update(['priority_id' => $priorityId]);
        }
    }

    /**
     * Migrate data back to enum columns (for rollback)
     */
    private function migrateDataBackToEnums(): void
    {
        // Get status mappings
        $statuses = DB::table('project_statuses')->pluck('name', 'id');
        $priorities = DB::table('project_priorities')->pluck('name', 'id');

        // Update projects with enum values
        foreach ($statuses as $id => $name) {
            DB::table('projects')
                ->where('status_id', $id)
                ->update(['status' => $name]);
        }

        foreach ($priorities as $id => $name) {
            DB::table('projects')
                ->where('priority_id', $id)
                ->update(['priority' => $name]);
        }
    }
}; 