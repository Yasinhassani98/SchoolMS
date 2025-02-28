<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('classroom')->orderBy('created_at', 'desc')->paginate(10);
        return view('students.index', ['students' => $students]);
    }
    public function create()
    {
        return view('students.create',[
            'classrooms' => Classroom::all()
        ]);
    }
    public function show(Student $student)
    {
        return view('students.show', ['student' => $student]);
    }
    public function store(StudentRequest $request)
    {
        $valedated=$request->validated();
        
        $post = new Student($valedated);
        if(request()->hasFile('image')) {
            $image = request()->file('image');
            $path = $image->store('Students', 'public');
            $post->image = $path;
        }
        $post->save();
        // Student::create();
        return redirect()->route('students.index')->with('success', 'Student created successfully');
    }
    public function edit(Student $student)
    {
        return view('students.edit',[
            'classrooms' => Classroom::all(),
            'student' => $student
        ]);
    }
    public function update(Request $request, Student $student)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'gender' => 'required|in:male,female',
            'classroom_id' => 'sometimes|required|exists:classrooms,id',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'Phone' => 'nullable|string|max:20',
            'enrollment_date' => 'nullable|date',
            'address' => 'nullable|max:255',
            'image' => 'nullable|image',
            'date_of_birth' => 'nullable|date',
            'parent_phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        if($request->hasFile('image')) {
            // Delete old image if exists
            if($student->image) {
                Storage::disk('public')->delete($student->image);
            }
            $image = $request->file('image');
            $path = $image->store('Students', 'public');
            $student->image = $path;
        }

        $student->update($request->except('image'));
        $student->save();

        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully');
    }
}
