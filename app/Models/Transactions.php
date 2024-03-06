<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'student_id',
        'course_id_amount',
        'total_amount',
        'type'
    ];
    protected $casts = [
        'course_id_amount' => 'json', // Cast 'options' to JSON array
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'course_id', 'course_id')
            ->select(['title', 'course_id'])
            ->whereIn('course_id', $this->getCourseIds());
    }

    protected function getCourseIds()
    {
        $courseIds = collect($this->course_id_amount)
            ->pluck('course_id')
            ->unique();

        return $courseIds->toArray();
    }
}
