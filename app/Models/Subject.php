<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher');
    }
    public function marks()
    {
        return $this->belongsToMany(Student::class, 'marks');
    }
}
