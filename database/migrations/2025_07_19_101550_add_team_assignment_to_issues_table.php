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
            // Add team assignment
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('set null');
            
            // Add index for performance
            $table->index(['team_id', 'issue_status']);
            $table->index(['team_id', 'assigned_to_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropIndex(['team_id', 'issue_status']);
            $table->dropIndex(['team_id', 'assigned_to_user_id']);
            $table->dropColumn('team_id');
        });
    }
};
