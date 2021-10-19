<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = ['semester','description','hours','year'];

    const WEEK_DAYS = [
        '0' =>'Clave',
        '1' =>'Lunes',
        '2' =>'Martes',
        '3' =>'Miercoles',
        '4' =>'Jueves',
        '5' =>'Viernes',
        '6' =>'Sabado',

    ];
}
