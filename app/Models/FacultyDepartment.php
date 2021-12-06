<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyDepartment extends Model
{
    use HasFactory;
    protected $fillable = ['faculty_vcode','department_vcode'];

    const TABLE_COLUMNS = [
        '0' => 'CODIGO',
        '1' =>'DEPARTAMENTO',
        '2' =>'EMAIL',
        '3' =>'CONTACTO'
    ];
}
