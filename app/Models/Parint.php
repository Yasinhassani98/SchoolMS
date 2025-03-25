<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Parint extends Model
{
    use HasFactory , Notifiable;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function children()
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
