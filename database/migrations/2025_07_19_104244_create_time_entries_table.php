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
        Schema::create('time_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->constrained('issues')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->unsignedInteger('time_minutes'); // Time spent in minutes
            $table->text('description')->nullable(); // What was worked on
            $table->date('work_date'); // Date the work was performed
            $table->timestamp('logged_at'); // When the entry was created
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['issue_id', 'work_date']);
            $table->index(['user_id', 'work_date']);
            $table->index(['project_id', 'work_date']);
            $table->index(['work_date', 'time_minutes']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_entries');
    }
};
