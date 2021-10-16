<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;
    protected $fillable = ['name','faculty','total_hour','carreer_at','state'];

    public function subjects(){
        return $this->hasMany(Subject::class, 'id');
    }
}
