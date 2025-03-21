<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_teacher');
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
    public function  getImageURL()
    {
        if ($this->image) {

            return url("/storage/" . $this->image);
        } else {
            if ($this->gender == 'male') {
                return url("/images/user.png");
            } else {
                return url("/images/female.png");
            }
        }
    }
}
