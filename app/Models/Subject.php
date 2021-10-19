<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = ['name','semester','department','total_hour','requisite','state','workshop','laboratory','equivalence','curriculum_id'];

    public function curriculums(){
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }

    public function couses(){
        return $this->hasMany(Course::class, 'id');
    }

}
