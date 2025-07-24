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
            // Update issue_status to use enum
            $table->enum('issue_status', [
                'waiting_for_planning',
                'planned',
                'in_progress',
                'on_hold',
                'feedback',
                'closed',
                'rejected'
            ])->default('waiting_for_planning')->change();

            // Update issue_priority to use enum
            $table->enum('issue_priority', [
                'low',
                'normal',
                'high',
                'urgent',
                'immediate'
            ])->default('normal')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            // Revert issue_status back to string
            $table->string('issue_status')->default('waiting_for_planning')->change();
            
            // Revert issue_priority back to string
            $table->string('issue_priority')->default('normal')->change();
        });
    }
};
