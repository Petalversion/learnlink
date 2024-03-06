<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    use HasFactory;

    protected $fillable = [
        'course_id',
        'instructor_id',
        'title',
        'summary',
        'description',
        'wyl',
        'requirements',
        'paid',
        'free',
        'draft',
        'difficulty',
        'image',
        'amount',
        'status',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function sales()
    {
        return $this->hasMany(Sales::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'course_id', 'course_id');
    }
    public function instructor()
    {
        return $this->hasOne(Instructor::class, 'instructor_id', 'instructor_id');
    }

    public function instructor_info()
    {
        return $this->hasOne(Instructor_info::class, 'instructor_id', 'instructor_id');
    }

    public function quiz()
    {
        return $this->hasMany(Exam::class, 'course_id', 'course_id');
    }
}
