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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('google_analytics_measurement_id')->nullable()->after('testimonials');
            $table->boolean('google_analytics_enabled')->default(false)->after('google_analytics_measurement_id');
            $table->boolean('google_analytics_debug')->default(false)->after('google_analytics_enabled');
            $table->boolean('google_analytics_anonymize_ip')->default(true)->after('google_analytics_debug');
            $table->boolean('google_analytics_send_page_view')->default(true)->after('google_analytics_anonymize_ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
