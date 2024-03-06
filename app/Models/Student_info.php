<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_info extends Model
{
    use HasFactory;
    protected $table = 'student_info';

    protected $fillable = [
        'student_id',
        'gcash',
        'paypal',
        'bio',
        'profile_picture',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
