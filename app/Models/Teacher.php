<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'role',
        'user_id',
        'phone',
        
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
