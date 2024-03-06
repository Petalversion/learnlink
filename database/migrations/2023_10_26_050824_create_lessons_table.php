<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateLessonsTable extends Migration
{
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('lesson_id', 9)->unique()->default(Str::random(9));
            $table->string('course_id', 255)->constrained('courses');
            $table->string('title');
            $table->text('content');
            $table->text('video_source')->nullable();
            $table->enum('status', ['draft', 'publish'])->default('draft'); // Added status column
            $table->timestamps();
        });

        // Set default values for existing records
        $lessons = \App\Models\Lesson::all();
        foreach ($lessons as $lesson) {
            $lesson->update(['lesson_id' => $this->generateLessonId()]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('lessons');
    }

    private function generateLessonId()
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 9);
    }
}
