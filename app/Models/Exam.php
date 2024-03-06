<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $table = 'examinations';
    protected $primaryKey = 'exam_id';
    protected $keyType = 'string';
    protected $fillable = [
        'exam_id',
        'course_id',
        'question',
        'choices',
        'answer',
        'type',
    ];

    protected $casts = [
        'choices' => 'json', // Cast 'options' to JSON array
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

