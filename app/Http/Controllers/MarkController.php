<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Http\Requests\StoreMarkRequest;
use App\Http\Requests\UpdateMarkRequest;
use App\Models\Level;
use App\Models\Teacher;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MarkController extends Controller
{
    public function index()
    {
        $marks = Mark::with(['teacher','student', 'subject', 'classroom', 'academicYear'])
            ->latest()
            ->paginate(10);

        return view('admin.marks.index', compact('marks'));
    }
    public function create()
    {
        $levels = Level::all();
        $teachers = Teacher::all();
        $students = Student::with('classroom.level')
            ->whereHas('classroom.level')
            ->get();

        $subjects = Subject::with('level')
            ->whereHas('level')
            ->get();

        $classrooms = Classroom::with('level')
            ->whereHas('level')
            ->get();

        $academicYears = AcademicYear::all();

        return view('admin.marks.create', compact('teachers', 'students', 'subjects', 'classrooms', 'academicYears','levels'));
    }

    public function store(StoreMarkRequest $request)
    {
        $academicYear = AcademicYear::where('is_current', true)->firstOrFail();
        
        // Make sure teacher_id is set
        $teacherId = $request->input('teacher_id');
        $studentIds = $request->input('student_ids', []);
        $marks = $request->input('marks', []);
        $classroomId = $request->input('classroom_id');
        $subjectId = $request->input('subject_id');
        $note = $request->input('note');
        foreach ($studentIds as $index => $studentId) {
            if (!isset($marks[$index]) || $marks[$index] === '') {
                continue;
            }
            Mark::create([
                'teacher_id' => $teacherId, // Ensure this is included
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'classroom_id' => $classroomId,
                'academic_year_id' => $academicYear->id,
                'mark' => $marks[$index],
                'note' => $note,
            ]);
        }
        
        return redirect()
            ->route('admin.marks.index')
            ->with('success', 'Marks added successfully for classroom ' . Classroom::find($classroomId)->name . ' and subject ' . Subject::find($subjectId)->name);
    }


    public function edit(Mark $mark): View
    {
        $teachers = Teacher::all();
        $students = Student::with('classroom.level')
            ->whereHas('classroom.level')
            ->get();

        $subjects = Subject::with('level')
            ->whereHas('level')
            ->get();

        $classrooms = Classroom::with('level')
            ->whereHas('level')
            ->get();

        $academicYears = AcademicYear::all();

        return view('admin.marks.edit', compact('teachers','mark', 'students', 'subjects', 'classrooms', 'academicYears'));
    }

    public function update(UpdateMarkRequest $request, Mark $mark): RedirectResponse
    {
        $academicYear = AcademicYear::where('is_current', true)->first();

        $data = array_merge($request->validated(),['academic_year_id' => $academicYear->id]);
        $mark->update($data);
        
        return redirect()
            ->route('admin.marks.index')
            ->with('success', 'Mark updated successfully');
    }

    public function destroy(Mark $mark): RedirectResponse
    {
        $mark->delete();
        
        return redirect()
            ->route('admin.marks.index')
            ->with('success', 'Mark deleted successfully');
    }
}
