<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('attachment_id', 9)->unique()->default(Str::random(9));
            $table->foreignId('lesson_id')->constrained('lessons');
            $table->string('attachment_path');
            $table->timestamps();
        });

        // Set default values for existing records
        $attachments = \App\Models\Attachment::all();
        foreach ($attachments as $attachment) {
            $attachment->update(['attachment_id' => $this->generateAttachmentId()]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('attachments');
    }

    private function generateAttachmentId()
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 9);
    }
}
