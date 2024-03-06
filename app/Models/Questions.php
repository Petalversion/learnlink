<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;
    protected $table = 'questions';

    protected $fillable = [
        'student_id',
        'course_id',
        'comment_id',
        'lesson_id',
        'comment',
    ];

    public function student_info()
    {
        return $this->belongsTo(Student_info::class, 'student_id', 'student_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function answer()
    {
        return $this->hasMany(Answers::class, 'comment_id', 'comment_id');
    }
}
