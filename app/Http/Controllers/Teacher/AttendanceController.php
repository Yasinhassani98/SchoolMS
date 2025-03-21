<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\AttendanceRequest;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Attendance::class);
        $attendances = Attendance::where('teacher_id', Auth::user()->teacher()->first()->id)
            ->with(['teacher', 'student', 'classroom', 'subject', 'academicYear'])
            ->orderBy('created_at', 'desc')->paginate(10);
        return view('teacher.attendances.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Attendance::class);
        $teacherId = Auth::user()->teacher()->first()->id;
        
        $classrooms = Classroom::whereHas('teachers', function($query) use ($teacherId) {
            $query->where('teachers.id', $teacherId);
        })->get();
        
        $subjects = Subject::whereHas('teachers', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();

        // If teacher has no assigned classrooms, provide empty collection for students
        $students = $classrooms->isEmpty() 
            ? collect() 
            : Student::whereIn('classroom_id', $classrooms->pluck('id'))
                ->select('id', 'name', 'classroom_id')
                ->orderBy('name')
                ->get();
        
        return view('teacher.attendances.create', compact('students', 'subjects', 'classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttendanceRequest $request)
    {
        Gate::authorize('create', Attendance::class);
        $academicYear = AcademicYear::where('is_current', true)->firstOrFail();
        $teacherId = Auth::user()->teacher()->first()->id;

        // Check for duplicate attendance records
        $existingAttendance = Attendance::where([
            'classroom_id' => $request->classroom_id,
            'subject_id' => $request->subject_id,
            'date' => $request->date,
        ]);

        // Check if we have multiple students
        if ($request->has('student_ids') && $request->has('attendance_status')) {
            $studentIds = $request->student_ids;
            $statuses = $request->attendance_status;
            
            // Check for existing records for these students on this date
            $duplicateStudents = $existingAttendance->whereIn('student_id', $studentIds)->pluck('student_id')->toArray();
            
            if (!empty($duplicateStudents)) {
                $duplicateNames = Student::whereIn('id', $duplicateStudents)->pluck('name')->implode(', ');
                return back()->withInput()->withErrors([
                    'general' => "Attendance already exists for: {$duplicateNames} on this date for this subject."
                ]);
            }
            
            // Create attendance records for each student
            $records = [];
            for ($i = 0; $i < count($studentIds); $i++) {
                $records[] = [
                    'teacher_id' => $teacherId,
                    'student_id' => $studentIds[$i],
                    'classroom_id' => $request->classroom_id,
                    'subject_id' => $request->subject_id,
                    'academic_year_id' => $academicYear->id,
                    'date' => $request->date,
                    'status' => $statuses[$i],
                    'note' => $request->note,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            // Use bulk insert for better performance
            Attendance::insert($records);
            
            return redirect()->route('teacher.attendances.index')
                ->with('success', 'Attendance records created successfully for ' . count($studentIds) . ' students.');
        } else {
            // Single student attendance (fallback)
            // Check for duplicate
            $duplicate = $existingAttendance->where('student_id', $request->student_id)->first();
            
            if ($duplicate) {
                $student = Student::find($request->student_id);
                return back()->withInput()->withErrors([
                    'student_id' => "Attendance already exists for {$student->name} on this date for this subject."
                ]);
            }
            
            Attendance::create([
                'teacher_id' => $teacherId,
                'student_id' => $request->student_id,
                'classroom_id' => $request->classroom_id,
                'subject_id' => $request->subject_id,
                'academic_year_id' => $academicYear->id, 
                'date' => $request->date,
                'status' => $request->status,
                'note' => $request->note,
            ]);
            
            return redirect()->route('teacher.attendances.index')
                ->with('success', 'Attendance record created successfully.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        Gate::authorize('update', $attendance);
        $teacherId = Auth::user()->teacher()->first()->id;

        return view('teacher.attendances.edit', [
            'attendance' => $attendance,
            'subjects' => Subject::whereHas('teachers', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })->get(),
            'classrooms' => Classroom::whereHas('teachers', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })->get(),
            'students' => Student::where('classroom_id', $attendance->classroom_id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttendanceRequest $request, Attendance $attendance)
    {
        Gate::authorize('update', $attendance);
        $attendance->update([
            'teacher_id' => Auth::user()->teacher()->first()->id, 
            'student_id' => $request->student_id,
            'classroom_id' => $request->classroom_id,
            'subject_id' => $request->subject_id,
            'date' => $request->date,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return redirect()->route('teacher.attendances.index')
            ->with('success', 'Attendance record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        Gate::authorize('delete', $attendance);
        $attendance->delete();

        return redirect()->route('teacher.attendances.index')
            ->with('success', 'Attendance record deleted successfully.');
    }
}
