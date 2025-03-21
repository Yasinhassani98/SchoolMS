<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $user_Id = Auth::user()->id;
        $Marks = Mark::where('student_id', $user_Id)->get();
        // dd($Marks[0]->subject->name);
        $subjects = $Marks->pluck('subject');
        // dd($subjects);
        return view('student.subjects' , compact('subjects'));
    }
}
