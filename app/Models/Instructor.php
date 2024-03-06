<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model implements Authenticatable
{
    use HasFactory;
    protected $table = 'instructor_users';
    protected $primaryKey = 'instructor_id';
    protected $keyType = 'string';

    protected $fillable = [
        'instructor_id',
        'name',
        'email',
        'password',
        'status',
        'role',
        // Add any other instructor-specific fields as needed
    ];

    // Explicitly implement the interface methods
    public function getAuthIdentifierName()
    {
        return 'instructor_id'; // Change this to match the name of your primary key column
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Change this to match the name of the remember token column
    }

    // Use accessors to format attributes
    public function getStatusAttribute($value)
    {
        return ucfirst($value); // Format the 'status' attribute to start with a capital letter
    }

    // Define any relationships or methods specific to instructor users here

    // You may want to define a scope for instructors with approved status
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // You can also define a scope for instructors with pending status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // And a scope for instructors with declined status
    public function scopeDeclined($query)
    {
        return $query->where('status', 'declined');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id', 'instructor_id');
    }


}