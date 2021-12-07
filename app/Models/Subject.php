<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = ['name','semester','vcode','hours','code','state','faculty_vcode'];

    public function faculties(){
        return $this->belongsTo(Carreer::class, 'faculty_vcode', 'vcode');
    }
    
    public function curriculums(){
        return $this->belongsToMany(Curriculum::class,'curriculum_subjects', 'subject_vcode', 'curriculum_vcode' ,'vcode','vcode');
    }

/////////////////////////////////////////////////////////////////

    public function couses(){
        return $this->hasMany(Course::class, 'id');
    }

    const SUBJECTS_COLUMNS = [
        '1' => 'CODIGO',
        '2' => 'NOMBRE',
        '3' => 'PREREQUISITO',
        '4' => 'HORAS',
        '5' => 'ESTADO',
    ];

    
    const SUBJECTS_OPTIONS = [
        '1' =>'Agregar Asignatura',
    ];
}
