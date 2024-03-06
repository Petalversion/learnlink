<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor_wallet extends Model
{
    use HasFactory;
    protected $table = 'instructor_wallet';

    protected $fillable = [
        'reference_id',
        'request_id',
        'instructor_id',
        'course_id',
        'amount',
        'type',
    ];
}
