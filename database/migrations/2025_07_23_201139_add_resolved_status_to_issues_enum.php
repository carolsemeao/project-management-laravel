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
        // Add 'resolved' to the existing issue_status enum
        DB::statement("ALTER TABLE issues MODIFY COLUMN issue_status ENUM(
            'waiting_for_planning',
            'planned',
            'in_progress',
            'on_hold',
            'feedback',
            'closed',
            'rejected',
            'resolved'
        ) NOT NULL DEFAULT 'waiting_for_planning'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'resolved' from the enum (revert to original values)
        DB::statement("ALTER TABLE issues MODIFY COLUMN issue_status ENUM(
            'waiting_for_planning',
            'planned',
            'in_progress',
            'on_hold',
            'feedback',
            'closed',
            'rejected'
        ) NOT NULL DEFAULT 'waiting_for_planning'");
    }
};
