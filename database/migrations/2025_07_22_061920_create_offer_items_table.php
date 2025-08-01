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
        Schema::create('offer_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('hours', 8, 2)->default(0.00);
            $table->decimal('rate_per_hour', 8, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Add indexes for performance
            $table->index(['offer_id', 'sort_order']);
            $table->index('offer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_items');
    }
};
