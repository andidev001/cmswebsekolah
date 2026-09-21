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
            $table->boolean('ppdb_active')->default(true)->after('external_ppdb_link');
            $table->text('ppdb_content')->nullable()->after('ppdb_active');
            $table->text('ppdb_requirements')->nullable()->after('ppdb_content');
            $table->text('ppdb_schedule')->nullable()->after('ppdb_requirements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['ppdb_active', 'ppdb_content', 'ppdb_requirements', 'ppdb_schedule']);
        });
    }
};
