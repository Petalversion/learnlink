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
        Schema::create('instructor_info', function (Blueprint $table) {
            $table->id();
            $table->string('instructor_id')->constrained('instructor_users');
            $table->string('gcash')->nullable();
            $table->string('paypal')->nullable();
            $table->longText('bio')->nullable();
            $table->string('profile_picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_info');
    }
};
