<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['team_id']);
            
            // Drop indexes related to team_id
            $table->dropIndex(['team_id', 'issue_status']);
            $table->dropIndex(['team_id', 'assigned_to_user_id']);
            
            // Drop the team_id column
            $table->dropColumn('team_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            // Add team_id column back
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('set null');
            
            // Add indexes back
            $table->index(['team_id', 'issue_status']);
            $table->index(['team_id', 'assigned_to_user_id']);
        });
    }
};
