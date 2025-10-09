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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('issue_title');
            $table->text('issue_description')->nullable();
            $table->foreignId('status_id')->constrained('issue_status')->onDelete('restrict');
            $table->foreignId('priority_id')->constrained('issue_priorities')->onDelete('restrict');
            $table->date('issue_due_date')->nullable();
            $table->integer('estimated_time_minutes')->nullable(); // In minutes
            $table->integer('logged_time_minutes')->default(0); // Total logged time
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_to_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Indexes for performance
            $table->index(['project_id', 'status_id']);
            $table->index(['assigned_to_user_id', 'issue_due_date']);
            $table->index('created_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
