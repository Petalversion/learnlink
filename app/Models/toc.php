<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class toc extends Model
{
    use HasFactory;
    protected $table = 'toc';
    protected $fillable = [
        'content',
    ];
}
