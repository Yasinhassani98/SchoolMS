<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'classroom_id',
        'academic_year_id',
        'mark',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }   
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }   
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }   

}
