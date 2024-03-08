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
        Schema::create('course_certificate', function (Blueprint $table) {
            $table->id();
            $table->string('result_id', 9)->constrained('quiz_attempts_counter');
            $table->string('student_id', 9)->constrained('student_users');
            $table->string('course_id', 9)->constrained('courses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_certificate');
    }
};
