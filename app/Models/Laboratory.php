<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','hours','course_id'];

    public function courses(){
        return $this->belongsTo(Course::class, 'course_id');
    }
}
