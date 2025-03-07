<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parint extends Model
{
    protected $fillable = [
        'user_id',
        'image',
        'name',
        'phone',
        'date_of_birth',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function getImageURL()
    {
        if ($this->image) {

            return url("/storage/" . $this->image);
        }

        return url("/images/user.png");
    }
}
