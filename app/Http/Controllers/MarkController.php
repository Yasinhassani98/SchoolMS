<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function index()
    {
        $marks = Mark::query()
            ->join('students', 'marks.student_id', '=', 'students.id')
            ->join('classrooms', 'students.classroom_id', '=', 'classrooms.id')
            ->join('academic_years', 'marks.academic_year_id', '=', 'academic_years.id')
            ->select(
                'marks.*',
                'students.name as student_name',
                'classrooms.name as classroom_name',
                'academic_years.name as academic_year_name'
            )
            ->with(['student', 'subject', 'classroom', 'academicYear'])
            ->orderBy('marks.created_at', 'desc')
            ->paginate(10);

        return view('admin.marks.index', compact('marks'));
    }
    public function create()
    {
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

        return view('admin.marks.create', compact('students', 'subjects', 'classrooms', 'academicYears'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'mark' => 'required|numeric|min:0|max:100',
        ]);
        Mark::create($validatedData);
        return redirect()->route('admin.marks.index')->with('success', 'Mark added successfully.');
    }
    public function edit(Mark $mark)
    {
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

        return view('admin.marks.edit', compact('mark', 'students', 'subjects', 'classrooms', 'academicYears'));
    }
    public function update(Request $request, Mark $mark)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'mark' => 'required|numeric|min:0|max:100',
        ]);
        $mark->update($validatedData);
        return redirect()->route('admin.marks.index')->with('success', 'Mark updated successfully');
    }
    public function destroy(Mark $mark)
    {
        $mark->delete();
        return redirect()->route('admin.marks.index')->with('success', 'Mark deleted successfully');
    }
}
