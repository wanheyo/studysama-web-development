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
        Schema::create('challenge', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('desc');
            $table->string('activity_type'); // mcq, flashcard, wsp
            $table->string('period_type'); // daily, weekly, monthly
            $table->integer('target_count'); // 5, 10, 20
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->integer('reward_xp')->default(0);
            $table->integer('reward_points')->default(0);
            $table->foreignId('badge_id')->constrained()->onDelete('cascade')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenge');
    }
};
