<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    //
    public function index(Request $request)
    {
        $attendances = Attendance::orderBy('classroom_id', 'desc')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.attendances.index', compact('attendances'));
    }
    public function create()
    {

        return view('admin.attendances.create', [
            'teachers' => Teacher::all(),
            'students' => Student::all(),
            'subjects' => Subject::all(),
            'classrooms' => Classroom::all(),
            'academicYears' => AcademicYear::all(),
        ]);
    }
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'date' => 'required|date',
            'note' => 'nullable',
            'status' => 'required|in:present,absent,late'
        ]);
        if (Auth::user()->hasRole(['admin', 'superadmin'])) {
            $validatedData['teacher_id'] = $request['teacher_id'];
        } else {
            $validatedData['teacher_id'] = Auth::user()->id;
        }
        Attendance::create($validatedData);
        return redirect()->route('attendances.index')->with('success', 'Attendadnce added successfully.');
    }
    public function show(Attendance $attendance)
    {
        return view('admin.attendances.show', compact('attendance'));
    }
    public function edit(Attendance $attendance)
    {
        return view('admin.attendances.edit', [
            'attendance' => $attendance,
            'teachers' => Teacher::all(),
            'students' => Student::all(),
            'subjects' => Subject::all(),
            'classrooms' => Classroom::all(),
            'academicYears' => AcademicYear::all(),
        ]);
    }
    public function update(Request $request, Attendance $attendance)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'date' => 'required|date',
            'note' => 'nullable|string',
            'status' => 'required|in:present,absent,late'
        ]);

        if (Auth::user()->hasRole(['admin', 'superadmin'])) {
            $validatedData['teacher_id'] = $request->teacher_id;
        } else {
            $validatedData['teacher_id'] = Auth::user()->id;
        }

        $attendance->update($validatedData);

        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully.');
    }
}
