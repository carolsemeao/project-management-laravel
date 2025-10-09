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
            $table->foreignId('issue_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->integer('time_minutes'); // Time spent in minutes
            $table->text('description')->nullable();
            $table->date('work_date'); // Date when work was performed
            $table->timestamp('logged_at')->useCurrent(); // When this entry was logged
            $table->timestamps();

            // Indexes for performance
            $table->index(['issue_id', 'work_date']);
            $table->index(['user_id', 'work_date']);
            $table->index(['project_id', 'work_date']);
            $table->index('logged_at');
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
