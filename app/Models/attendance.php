<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_id',  
        'student_id',    
        'status',
        'date',
    ];
}
