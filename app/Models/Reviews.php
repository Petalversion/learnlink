<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;
    protected $table = 'reviews';

    protected $fillable = [
        'student_id',
        'course_id',
        'review_id',
        'score',
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
}
