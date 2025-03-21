<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{
    public function index(){
        $student = Auth::user()->student;
        $marks = $student->marks;
        // dd($marks);
        return view('student.marks',compact(['marks','student']));
    }
}
