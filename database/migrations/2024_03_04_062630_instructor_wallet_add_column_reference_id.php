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
        Schema::table('instructor_wallet', function (Blueprint $table) {
            $table->string('reference_id')->nullable()->after('id');
            $table->string('request_id')->nullable()->after('reference_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instructor_wallet', function (Blueprint $table) {
            $table->dropColumn('reference_id');
            $table->dropColumn('request_id');
        });
    }
};
