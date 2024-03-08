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
        Schema::create('quiz_attempts_counter', function (Blueprint $table) {
            $table->id();
            $table->string('course_id', 9)->constrained('courses');
            $table->string('student_id', 9)->constrained('student_users');
            $table->string('result_id', 9);
            $table->string('score');
            $table->integer('attempt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts_counter');
    }
};
