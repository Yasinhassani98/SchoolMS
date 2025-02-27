<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::orderby('created_at', 'desc')->paginate(10);
        return view('teachers.index', ['teachers' => $teachers]);
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
            'name' => 'required|min:3|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
            'email' => 'required|email|unique:teachers',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'specialization' => 'nullable|max:255',
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
