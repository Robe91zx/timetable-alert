<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\College;
use App\Models\Carreer;
use App\Models\Subject;


class Faculty extends Model
{
    use HasFactory;
    protected $fillable = ['vcode','code','name','website','email','phone'];

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'faculty_departments','faculty_vcode','department_vcode','vcode','vcode');
    }                                                   //pivot                     1               2                1     2

    public function colleges()
    {
        return $this->belongsToMany(College::class, 'faculty_colleges','faculty_vcode','college_vcode','vcode','vcode');
    } 

    public function carreers()
    {
        return $this->belongsToMany(Carreer::class, 'faculty_carreers','faculty_vcode','carreer_vcode','vcode','vcode');
    } 

    public function subjects()
    {
        return $this->hasMany(Subject::class,'faculty_vcode', 'vcode');
    } 

    const FACULTY_COLUMNS = [
        '0' =>'Codigo',
        '1' =>'Facultad',
        '2' =>'Contacto',
        '3' =>'Telefono',
    ];

    const FACULTY_OPTIONS = [
        '1' =>'Agregar Facultad',
        '2' =>'Asignar Departamentos a Facultades',
        '3' =>'Asignar Departamentos a Facultades desde Excel',
        '4' =>'Asignar Escuelas a Facultades',
        '5' =>'Asignar Escuelas a Facultades desde Excel',
        '6' =>'Asignar Carreras a Facultades',
        '7' =>'Asignar Carreras a Facultades desde Excel',
        '8' =>'Asignar Asignaturas a Facultades',
        '9' =>'Asignar Asignaturas a Facultades desde Excel',
        '10' =>'Editar Facultades'
    ];

    const FACULTY_SUBJECTS_COLUMNS = [
        '0' =>'Facultad',
        '1' =>'Departamento/Escuela',
        '2' =>'Contacto',
        '3' =>'Telefono',
    ];

    const FACULTYTESTING2_COLUMNS = [
        '0' =>'Facultad',
        '1' =>'Carrera',
        '2' =>'Contacto',
        '3' =>'Telefono',
    ];
}
