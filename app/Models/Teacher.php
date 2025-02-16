<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Teacher extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function classrooms(){
        return $this->belongsToMany(Classroom::class,'classroom_teacher');
    }
    public function subjects(){
        return $this->belongsToMany(Subject::class,'subject_teacher');
    }
}
