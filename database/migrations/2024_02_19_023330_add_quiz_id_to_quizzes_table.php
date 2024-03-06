<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('quiz_id', 9)->unique()->default(Str::random(9))->after('id');
        });

        $quizzes = \App\Models\Quiz::all();
        foreach ($quizzes as $quiz) {
            $quiz->update(['lecture_id' => $this->generateQuizId()]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('quiz_id');
        });
    }

    private function generateQuizId()
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 9);
    }
};
