<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject_has_Course extends Model
{
    use HasFactory;
    protected $fillable = ['subject_vcode','course_vcode'];

    const SUBJECT_COURSES_COLUMNS = [
        '0' => 'CODIGO',
        '1' =>'ASIGNATURA',
        '2' =>'ESTADO'
    ];
}
