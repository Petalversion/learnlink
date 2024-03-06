<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;
    protected $table = 'lectures';
    protected $primaryKey = 'lecture_id';
    protected $keyType = 'string';
    protected $fillable = [
        'lecture_id',
        'lesson_id',
        'title',
        'content',
        'uploadedFiles',
        'video_source',
    ];

    protected $casts = [
        'uploadedFiles' => 'json', // Cast 'options' to JSON array
    ];

    // Define the relationship with the Course model
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'lesson_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'lesson_id', 'lesson_id');
    }

}
