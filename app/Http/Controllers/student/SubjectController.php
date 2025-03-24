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
        $student = Auth::user()->student->first();
        $subjects = Subject::where('level_id', $student->classroom->level_id)->get();
        return view('student.subjects', compact('subjects'));
    }
    public function show(Subject $subject)
    {
        return view('student.subject', compact('subject'));
    }
}
