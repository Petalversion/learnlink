<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model implements Authenticatable
{
    use HasFactory;
    protected $table = 'student_users';

    protected $fillable = [
        'name', 'email', 'password', 'role',
        // Add any other student-specific fields as needed
    ];

    // Explicitly implement the interface methods
    public function getAuthIdentifierName()
    {
        return 'id'; // Change this to match the name of your primary key column
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

    public function student()
    {
        return $this->hasMany(Questions::class, 'student_id', 'student_id');
    }

    // Define any relationships or methods specific to student users here
}
