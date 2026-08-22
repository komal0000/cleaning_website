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
            $table->string('contact_email')->nullable()->after('meta_keywords');
            $table->string('contact_phone')->nullable()->after('contact_email');
            $table->string('contact_address')->nullable()->after('contact_phone');
            $table->string('contact_facebook')->nullable()->after('contact_address');
            $table->string('contact_map')->nullable()->after('contact_facebook');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('contact_email');
            $table->dropColumn('contact_phone');
            $table->dropColumn('contact_address');
            $table->dropColumn('contact_facebook');
            $table->dropColumn('contact_map');
        });
    }
};
