<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id', 18)->unique()->default($this->generateTransactionId());
            $table->string('student_id', 9)->constrained('student_users');
            $table->json('course_id_amount');
            $table->decimal('total_amount', 10, 2);
            $table->enum('type', ['gcash', 'paypal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }

    private function generateTransactionId()
    {
        $date_today = date("Ymd");
        $random_string = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 7);
        return 'LL' . $date_today . '-' . $random_string;
    }
};
