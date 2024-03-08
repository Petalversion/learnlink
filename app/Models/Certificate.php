<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $table = 'course_certificate';

    protected $fillable = [
        'student_id',
        'course_id',
        'result_id',
    ];

    public function student_info()
    {
        return $this->belongsTo(Student_info::class, 'student_id', 'student_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
}
