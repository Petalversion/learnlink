<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->string('exam_id', 9)->unique()->default(Str::random(9));
            $table->string('course_id', 255)->constrained('courses');
            $table->enum('type', ['ToF', 'MC'])->default('ToF');
            $table->string('question');
            $table->string('answer');
            $table->json('choices');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('examinations');
    }
};