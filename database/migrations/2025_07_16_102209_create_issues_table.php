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
            $table->string('issue_status')->default('waiting_for_planning');
            $table->string('issue_priority')->default('normal');
            $table->timestamp('issue_due_date')->nullable();
            $table->string('issue_accumulated_time')->nullable();
            $table->integer('issue_project_id')->nullable();
            $table->string('issue_assigned_to')->nullable();
            $table->string('issue_created_by')->nullable();
            $table->timestamps();
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
