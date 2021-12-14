<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum_hasSubject extends Model
{
    use HasFactory;
    protected $fillable = ['curriculum_vcode','subject_vcode'];

}
