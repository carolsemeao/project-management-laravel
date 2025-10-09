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
        Schema::create('project_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->date('assigned_at')->nullable();
            $table->date('removed_at')->nullable();
            $table->timestamps();

            // Allow users to have multiple roles per project, but prevent duplicate role assignments
            $table->unique(['project_id', 'user_id', 'role_id'], 'unique_project_user_role_assignment');

            // Indexes
            $table->index(['project_id', 'removed_at']); // For active assignments
            $table->index(['user_id', 'removed_at']); // For user's active projects
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_user');
    }
};
