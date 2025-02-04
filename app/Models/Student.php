<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function marks(){
        return $this->belongsToMany(Subject::class,'marks');
    }
}
