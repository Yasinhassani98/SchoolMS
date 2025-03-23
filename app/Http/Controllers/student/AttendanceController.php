<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index() {


        $user_id = Auth::user()->id;
        $attendances = Attendance::where('student_id', $user_id)->get();

        return view('student.attendance', compact('attendances'));
    }
}
