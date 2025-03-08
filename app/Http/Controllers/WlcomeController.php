<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Level;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class WlcomeController extends Controller
{
    public function welcome(){
        $students = Student::all();
        $teachers = Teacher::all();
        $levels = Level::all();
        $classrooms = Classroom::all();

        return view('content',compact(['students','teachers','levels','classrooms']));
    }
}
