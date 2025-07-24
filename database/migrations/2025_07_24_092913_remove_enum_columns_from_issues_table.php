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
            $table->dropColumn(['issue_status', 'issue_priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            // Restore the enum columns if needed (for rollback)
            $table->enum('issue_status', [
                'waiting_for_planning',
                'planned',
                'in_progress',
                'on_hold',
                'feedback',
                'closed',
                'rejected',
                'resolved'
            ])->default('waiting_for_planning');

            $table->enum('issue_priority', [
                'low',
                'normal',
                'high',
                'urgent',
                'immediate'
            ])->default('normal');
        });
    }
};
