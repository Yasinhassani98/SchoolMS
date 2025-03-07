<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
