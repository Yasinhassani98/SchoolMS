<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    public function index(Request $request)
    {
        $attendances = Attendance::with(['student', 'teacher', 'classroom', 'subject', 'academicYear'])
            ->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.attendances.index', compact('attendances'));
    }
    public function create()
    {

        return view('admin.attendances.create', [
            'teachers' => Teacher::all(),
            'students' => Student::all(),
            'subjects' => Subject::all(),
            'classrooms' => Classroom::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'required|exists:students,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'note' => 'nullable|string',
            'attendance_status' => 'required|array',
            'attendance_status.*' => 'required|in:present,absent,late'
        ]);

        $academicYear = AcademicYear::where('is_current', true)->firstOrFail();
        $teacherId = Auth::user()->hasRole(['admin', 'superadmin'])
            ? $request->input('teacher_id')
            : Auth::user()->id;

        foreach ($request->student_ids as $index => $studentId) {
            Attendance::create([
                'student_id' => $studentId,
                'classroom_id' => $request->classroom_id,
                'subject_id' => $request->subject_id,
                'academic_year_id' => $academicYear->id,
                'date' => $request->date,
                'note' => $request->note,
                'status' => $request->attendance_status[$index] ?? 'absent', // استخدام الاسم الصحيح
                'teacher_id' => $teacherId,
            ]);
            $student = Student::findOrFail($studentId);
            $parent = $student->parent;
            $subject = Subject::find($request->subject_id);
            $notification = new GeneralNotification(
                'New Mark Added',
                "A new mark has been added for {$subject->name}.",
                'info'
            );
            $student->user->notify($notification);
            $parent->user->notify($notification);
        }

        return redirect()->route('admin.attendances.index')->with('success', 'Attendance recorded successfully.');
    }
    public function edit(Attendance $attendance)
    {
        return view('admin.attendances.edit', [
            'attendance' => $attendance,
            'teachers' => Teacher::all(),
            'students' => Student::all(),
            'subjects' => Subject::all(),
            'classrooms' => Classroom::all(),
        ]);
    }
    public function update(Request $request, Attendance $attendance)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'note' => 'nullable|string',
            'status' => 'required|in:present,absent,late'
        ]);
        $academicYear = AcademicYear::where('is_current', true)->firstOrFail();
        if (Auth::user()->hasRole(['admin', 'superadmin'])) {
            $validatedData['teacher_id'] = $request->teacher_id;
        } else {
            $validatedData['teacher_id'] = Auth::user()->id;
        }
        $data = array_merge($validatedData, ['academic_year_id' => $academicYear->id]);
        $attendance->update($data);

        // Send notification about attendance update
        $student = Student::findOrFail($request->student_id);
        $parent = $student->parent;
        $subject = Subject::find($request->subject_id);
        $notification = new GeneralNotification(
            'Attendance Updated',
            "Your attendance status has been updated for {$subject->name}.",
            'info'
        );
        $student->user->notify($notification);
        if ($parent) {
            $parent->user->notify($notification);
        }

        return redirect()->route('admin.attendances.index')->with('success', 'Attendance updated successfully.');
    }
}
