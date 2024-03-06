<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['attachment_id', 'lesson_id', 'attachment_path'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'attachment_id');
    }
}