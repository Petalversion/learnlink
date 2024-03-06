<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateStudentUsersTable extends Migration
{
    public function up()
    {
        Schema::create('student_users', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 9)->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('student');
            $table->timestamps();
        });

        // Set default values for existing records
        $students = \App\Models\Student::all();
        foreach ($students as $student) {
            $student->update(['student_id' => $this->generateStudentId()]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('student_users');
    }

    private function generateStudentId()
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 9);
    }
}
