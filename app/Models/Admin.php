<?php

namespace App\Models;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model implements Authenticatable
{
    use HasFactory;
    protected $table = 'admin_users';

    protected $fillable = [
        'admin_id','name', 'email', 'password', 'role',
        // Add any other admin-specific fields as needed
    ]; 
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
}