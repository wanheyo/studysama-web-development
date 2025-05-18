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
        Schema::table('challenges', function (Blueprint $table) {
            $table->dropForeign('challenge_badge_id_foreign');
            $table->unsignedBigInteger('badge_id')->nullable()->change();
            $table->foreign('badge_id')->references('id')->on('badges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->dropForeign('challenge_badge_id_foreign');
            $table->unsignedBigInteger('badge_id')->nullable(false)->change();
            $table->foreign('badge_id')->references('id')->on('badges')->onDelete('cascade');
        });
    }
};
