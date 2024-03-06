<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Question\Question;

class Answers extends Model
{
    use HasFactory;
    protected $table = 'answers';

    protected $fillable = [
        'instructor_id',
        'comment_id',
        'comment',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id', 'instructor_id');
    }
    public function instructor_info()
    {
        return $this->belongsTo(Instructor_info::class, 'instructor_id', 'instructor_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'comment_id', 'comment_id');
    }
}
