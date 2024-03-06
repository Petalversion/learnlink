<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateInstructorUsersTable extends Migration
{
    public function up()
    {
        Schema::create('instructor_users', function (Blueprint $table) {
            $table->id();
            $table->string('instructor_id', 9)->unique()->default($this->generateInstructorId());
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
            $table->string('role')->default('instructor');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instructor_users');
    }

    private function generateInstructorId()
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 9);
    }
}
