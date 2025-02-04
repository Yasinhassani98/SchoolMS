<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    public function level(){
        return $this->belongsTo(Level::class);
    }
    public function students(){
        return $this->hasMany(Student::class);
    }
    public function teachers(){
        return $this->belongsToMany(Teacher::class,'classroom_teacher');
    }
}
