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
            // Update the existing project_id column to be the right type and nullable
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
            // Revert to original type
            $table->integer('project_id')->nullable()->change();
        });
    }
};
