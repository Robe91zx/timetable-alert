<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['state','semester','hours','description','group','subject_id'];

//one to Many
    public function subjects(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

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
}
