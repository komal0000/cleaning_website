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
            $table->boolean('use_image_in_home')->default(false)->after('about_image_per_line');
            $table->json('home_image_list')->nullable()->after('use_image_in_home');
            $table->integer('home_image_per_line')->default(1)->after('home_image_list');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('use_image_in_home');
            $table->dropColumn('home_image_list');
            $table->dropColumn('home_image_per_line');
        });
    }
};
