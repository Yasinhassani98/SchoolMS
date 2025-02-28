<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function marks()
    {
        return $this->belongsToMany(Subject::class, 'marks');
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
    public function getImageURL()
    {
        if ($this->image) {

            return url("/storage/" . $this->image);
        } else {
            if ($this->gender == 'male') {

                return url("/male/user.png");
            } else {
                return url("/female/female.png");
            }
        }
    }
}
