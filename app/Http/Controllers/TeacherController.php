<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::orderby('created_at', 'desc')->paginate(10);
        // dd($teachers);
        return view('teachers.index', ['teachers' => $teachers])->with('success', 'Teacher created successfully');
    }
    public function create()
    {
        return view('teachers.create');
    }
    public function show()
    {
        return view('teachers.show');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'email' => 'required|email|unique:teachers',
            'phone' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'specialization' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);
        Teacher::create($request->all());
        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully');
    }
    public function edit()
    {
        return view('teachers.edit');
    }
    public function update(Request $request)
    {
        dd($request);
    }
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully');
    }
}
