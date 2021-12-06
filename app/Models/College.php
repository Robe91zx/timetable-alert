<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Faculty;
use App\Models\Carreer;

class College extends Model
{
    use HasFactory;

    protected $fillable = ['vcode','code','name','phone','email','website'];

    public function faculties(){
        return $this->belongsToMany(Faculty::class, 'faculty_colleges', 'college_vcode','faculty_vcode','vcode','vcode');
    }

    public function carreers(){
        return $this->belongsToMany(Carreer::class, 'college_carreers','college_vcode','carreer_vcode', 'vcode', 'vcode');
    }

    const COLLEGES_COLUMNS = [
        '0' => 'CODIGO',
        '1' => 'ESCUELA',
        '2' => 'CONTACTO',
        '3' => 'TELEFONO',
    ];

    const COLLEGES_OPTIONS = [
        '1' =>'Agregar Escuela',
        '2' => 'Asignar Carreras a Escuelas',
        '3' => 'Asignar Carreras a Escuelas desde Excel',
    ];

    const CARREERS_COLUMNS = [
        '0' => 'CODIGO',
        '1' => 'ESCUELA',
    ];



}
