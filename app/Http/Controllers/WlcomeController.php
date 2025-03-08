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
        $studentsNumber = Student::all()->count();
        $teachersNumber = Teacher::all()->count();
        $levels = Level::withCount('classrooms')->get();
        $classroomsNumber = Classroom::all()->count();
        return view('admin.dashboard',compact(['levels','studentsNumber','teachersNumber','classroomsNumber']));

    }
}
