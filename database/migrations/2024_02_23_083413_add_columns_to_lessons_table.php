<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->text('content')->nullable()->after('title');
            $table->json('uploadedFiles')->nullable()->after('content');
            $table->text('video_source')->nullable()->after('uploadedFiles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('uploadedFiles');
            $table->dropColumn('video_source');
        });
    }
};
