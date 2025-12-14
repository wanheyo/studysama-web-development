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
        Schema::table('system_notifications', function (Blueprint $table) {

            $table->unsignedBigInteger('report_id')->after('noti_type')->nullable();

            $table->foreign('report_id')
                ->references('id')->on('reports')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_notifications', function (Blueprint $table) {
            $table->dropColumn('report_id');
        });
    }
};
