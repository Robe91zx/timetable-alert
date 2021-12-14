<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carreer extends Model
{
    use HasFactory;
    protected $fillable = ['code','name','website','vcode','phone','email'];

    public function faculties(){
        return $this->belongsToMany(Faculty::class, 'faculty_has_carreers','carreer_vcode','faculty_vcode','vcode','vcode');
    } 
    
    public function departments(){
        return $this->belongsToMany(Department::class,'department_has_carreers','carreer_vcode', 'department_vcode', 'vcode', 'vcode');
    }

    public function colleges(){
        return $this->belongsToMany(Department::class, 'college_has_carreers','carreer_vcode', 'department_vcode', 'vcode', 'vcode');
    }
//en este caso, indico la clave foranea + el valor al que este referencia
    public function curriculums(){
        return $this->hasMany(Curriculum::class, 'carreer_vcode','vcode');
    }

    const CARREERS_COLUMNS = [
        '0' => 'FACULTAD',
        '1' => 'NOMBRE',
        '2' => 'CORREO',
        '3' => 'CONTACTO'
    ];

    const CURRICULUMS_COLUMNS = [
        '0' => 'CODIGO',
        '1' => 'NOMBRE',
        '2' => 'DURACION',
        '3' => 'ESTADO'
    ];

    const CARREERS_OPTIONS = [
        '1' =>'Agregar Carrera',  
    ];
}
