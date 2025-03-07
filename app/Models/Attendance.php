<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'date',
        'status',
        'teacher_id',
        'student_id',
        'subject_id',
        'classroom_id',
        'academic_year_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
