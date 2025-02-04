<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function classrooms(){
        return $this->belongsToMany(Classroom::class,'classroom_teacher');
    }
    public function subjects(){
        return $this->belongsToMany(Subject::class,'subject_teacher');
    }
}
