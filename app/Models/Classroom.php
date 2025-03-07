<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Classroom extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function level(){
        return $this->belongsTo(Level::class);
    }
    public function students(){
        return $this->hasMany(Student::class);
    }
    public function teachers(){
        return $this->belongsToMany(Teacher::class,'classroom_teacher');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
