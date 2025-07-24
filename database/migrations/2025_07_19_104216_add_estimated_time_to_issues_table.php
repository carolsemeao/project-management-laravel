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
            // Add estimated time in minutes for precision
            $table->unsignedInteger('estimated_time_minutes')->nullable()->after('issue_accumulated_time');
            
            // Update the accumulated time field to be minutes instead of string  
            $table->unsignedInteger('logged_time_minutes')->nullable()->after('estimated_time_minutes');
            
            // Add index for time tracking queries
            $table->index(['project_id', 'estimated_time_minutes']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropIndex(['project_id', 'estimated_time_minutes']);
            $table->dropColumn(['estimated_time_minutes', 'logged_time_minutes']);
        });
    }
};
