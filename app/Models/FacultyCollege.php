<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyCollege extends Model
{
    use HasFactory;
    protected $fillable = ['faculty_vcode','college_vcode'];

}
