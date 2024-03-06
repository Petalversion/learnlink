<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor_info extends Model
{
    use HasFactory;
    protected $table = 'instructor_info';

    protected $fillable = [
        'instructor_id',
        'gcash',
        'paypal',
        'bio',
        'profile_picture',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id', 'instructor_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id', 'instructor_id');
    }
}
