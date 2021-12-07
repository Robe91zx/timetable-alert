<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Faculty;
use App\Models\Carreer;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['vcode','code','name','phone','email','website', 'vcode'];

    public function faculties(){
        return $this->belongsToMany(Faculty::class, 'faculty_has_departments', 'department_vcode','faculty_vcode','vcode','vcode');
    }

    public function carreers(){
        return $this->belongsToMany(Carreer::class, 'department_has_carreers','department_vcode','carreer_vcode','vcode','vcode');
    }
    
    const DEPARTMENTS_COLUMNS = [
        '0' => 'CODIGO',
        '1' => 'DEPARTAMENTO',
        '2' => 'CONTACTO',
        '3' => 'TELEFONO',
    ];

    const DEPARTMENTS_OPTIONS = [
        '1' =>'Agregar Departamento',
        '2' => 'Asignar Carreras a Departamentos',
        '3' => 'Asignar Carreras a Departamentos desde Excel',
    ];

    const CARREERS_COLUMNS = [
        '0' => 'CODIGO',
        '1' => 'DEPARTAMENTO',
    ];

}
