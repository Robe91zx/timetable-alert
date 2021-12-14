<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['vcode','code','group','description', 'semester','hours','subject_vcode','state'];

    public function subjects(){
        return $this->belongsTo(Subject::class, 'subject_vcode','vcode');
    }




////////////////////////////////////////////////////////
    

    public function workshop(){
        return $this->hasOne(Workshop::class, 'id');
    }

    public function laboratory(){
        return $this->hasOne(Laboratory::class, 'id');
    }

//Many to Many
    public function user(){
        return $this->belongsToMany(User::class, 'user_course');
    }

    const COURSE_COLUMNS = [
        '0' =>'Codigo',
        '1' =>'asignatura',
        '2' =>'grupo',
        '3' =>'semestre',
    ];

    const COURSE_OPTIONS = [
        '1' =>'Agregar Facultad',
        '2' =>'Asignar Departamentos a Facultades',
        '3' =>'Asignar Departamentos a Facultades desde Excel',
        '4' =>'Editar Facultades'
    ];
}
