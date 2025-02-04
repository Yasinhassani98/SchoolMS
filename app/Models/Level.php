<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public function classrooms(){
        return $this->hasMany(Classroom::class);
    }
    public function subjects(){
        return $this->hasMany(Subject::class);
    }

}
