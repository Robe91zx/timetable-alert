<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty_hasCollege extends Model
{
    use HasFactory;
    protected $fillable = ['faculty_vcode','college_vcode'];

}
