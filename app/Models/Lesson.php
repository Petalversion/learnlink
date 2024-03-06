<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $table = 'lessons';
    protected $primaryKey = 'lesson_id';
    protected $keyType = 'string';
    protected $fillable = [
        'lesson_id',
        'course_id',
        'title',
        'content',
        'uploadedFiles',
        'video_source',
    ];

    protected $casts = [
        'uploadedFiles' => 'json', // Cast 'options' to JSON array
    ];
    // Define the relationship with the Course model
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function lecture()
    {
        return $this->hasMany(Lecture::class, 'lesson_id', 'lesson_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'lesson_id', 'lesson_id');
    }

}
