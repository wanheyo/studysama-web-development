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
        Schema::create('forum_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_course_id')->constrained()->onDelete('cascade');
            $table->foreignId('forum_post_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->integer('status')->default(1);
            $table->foreignId('forum_reply_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('resource_file_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_replies');
    }
};
