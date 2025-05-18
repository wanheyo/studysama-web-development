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
        Schema::create('user_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('activity_type'); // mcq, flashcard, wsp
            $table->integer('xp_earned')->default(0);
            $table->integer('max_xp')->default(0);
            $table->integer('points_earned')->default(0);
            $table->integer('token_used')->default(0);
            $table->string('topic')->nullable();
            $table->string('file_name')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activity_logs');
    }
};
