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
            // Add foreign key columns for user relationships
            $table->foreignId('assigned_to_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Add indexes for better query performance
            $table->index('assigned_to_user_id');
            $table->index('created_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['assigned_to_user_id']);
            $table->dropForeign(['created_by_user_id']);
            
            // Drop indexes
            $table->dropIndex(['assigned_to_user_id']);
            $table->dropIndex(['created_by_user_id']);
            
            // Drop columns
            $table->dropColumn(['assigned_to_user_id', 'created_by_user_id']);
        });
    }
};
