<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_id', 9)->unique();
            $table->string('instructor_id', 9)->constrained('instructor_users');
            $table->string('title');
            $table->text('summary');
            $table->boolean('paid')->default(false);
            $table->boolean('free')->default(false);
            $table->boolean('draft')->nullable()->default(false);
            $table->enum('difficulty', ['beginner', 'intermediate', 'expert']);
            $table->string('image')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->enum('status', ['publish', 'draft'])->default('draft');
            $table->timestamps();
        });

        // Set default values for existing records
        $courses = \App\Models\Course::all();
        foreach ($courses as $course) {
            $course->update(['course_id' => Str::random(9), 'status' => 'draft']);
        }
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}


