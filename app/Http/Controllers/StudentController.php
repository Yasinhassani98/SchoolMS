<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('created_at', 'desc')->paginate(10);
        return view('students.index', ['students' => $students]);
    }
    public function create()
    {
        return view('students.create');
    }
    public function show(Student $student)
    {
        return view('students.show', ['student' => $student]);
    }
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'classroom_id' => 'sometimes|required|exists:classrooms,id',
            'email' => 'required|email|unique:students,email',
            'Phone' => 'nullable',
            'enrollment_date' => 'nullable|date',
            'address' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'parent_phone' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);
        // dd($request);
        Student::create($request->all());
        return redirect()->route('students.index')->with('success', 'Student created successfully');
    }
    public function edit(Student $student)
    {
        return view('students.edit', ['student' => $student]);
    }
    public function update(Request $request, Student $student)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'Phone' => 'nullable',
            'enrollment_date' => 'nullable|date',
            'address' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'parent_phone' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);
        $student->update($request->all());
        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully');
    }
}
