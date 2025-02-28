<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function index()
    {
        $marks = Mark::with('student', 'subject')->orderBy(Student::select('name')->whereColumn('students.id', 'marks.student_id'))->get();
        // dd($marks);
        return view('marks.index', compact('marks'));
    }
    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();
        return view('marks.create', compact('students', 'subjects'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'mark' => 'required|numeric|min:0|max:100',
        ]);
        // dd($validatedData);

        Mark::create($validatedData);

        return redirect()->route('marks.index')->with('success', 'Mark added successfully.');
    }
    public function edit(Mark $mark)
    {
        $students = Student::all();
        $subjects = Subject::all();
        return view('marks.edit', compact('mark', 'students', 'subjects'));
    }
    public function update(Request $request,Mark $mark)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'mark' => 'required|numeric|min:0|max:100',
        ]);
        $mark->update($validatedData);
        return redirect()->route('marks.index')->with('success','The mark updated');
    }
    public function destroy(Mark $mark){
        $mark->delete();
        return redirect()->route('marks.index')->with('success','the mark is deleted');
    }
}
