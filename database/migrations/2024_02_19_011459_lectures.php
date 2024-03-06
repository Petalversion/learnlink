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
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->string('lecture_id', 9)->unique()->default(Str::random(9));
            $table->string('lesson_id', 255)->constrained('lessons');
            $table->string('title');
            $table->json('uploadedFiles')->nullable();
            $table->text('video_source')->nullable();
            $table->timestamps();
        });

        // Set default values for existing records
        $lectures = \App\Models\Lecture::all();
        foreach ($lectures as $lecture) {
            $lecture->update(['lecture_id' => $this->generateLectureId()]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('lectures');
    }

    private function generateLectureId()
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 9);
    }
};
