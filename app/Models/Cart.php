<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'amount',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'course_id', 'course_id');
    }
}
