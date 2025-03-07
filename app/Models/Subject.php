<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'level_id',
        'description',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher');
    }
    public function marks()
    {
        return $this->belongsToMany(Student::class, 'marks');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
