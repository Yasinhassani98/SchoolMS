<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index() {
        
        $studentId = Auth::user()->student()->first()->id;
        $attendances = Attendance::where('student_id', $studentId)->get();
        return view('student.attendance', compact('attendances'));
    }
}
