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
            // Rename issue_project_id to project_id and update type
            $table->renameColumn('issue_project_id', 'project_id');
            $table->unsignedBigInteger('project_id')->nullable()->change();
        });
        
        // Note: We'll add the foreign key constraint later via seeder
        // after we have proper project data
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            // Revert to original type and name
            $table->integer('project_id')->nullable()->change();
            $table->renameColumn('project_id', 'issue_project_id');
        });
    }
};
