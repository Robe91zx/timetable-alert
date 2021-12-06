<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultySubject extends Model
{
    use HasFactory;
    protected $fillable = ['faculty_vcode','subject_vcode'];

    const FACULTY_SUBJECTS_COLUMNS = [
        '0' => 'CODIGO',
        '1' =>'ASIGNATURA',
        '2' =>'ESTADO'
    ];
}
