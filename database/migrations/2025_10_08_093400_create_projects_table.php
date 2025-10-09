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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->date('start_date')->nullable();
            $table->foreignId('status_id')->constrained('project_statuses')->onDelete('restrict');
            $table->foreignId('priority_id')->constrained('project_priorities')->onDelete('restrict');
            $table->string('color', 7)->default('#007bff'); // Hex color for UI
            $table->decimal('budget', 10, 2)->nullable();
            $table->foreignId('company_id')->constrained()->onDelete('restrict');
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null'); // Specific contact person
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Add indexes for performance
            $table->index(['status_id', 'due_date']);
            $table->index(['created_by_user_id', 'status_id']);
            $table->index('priority_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
