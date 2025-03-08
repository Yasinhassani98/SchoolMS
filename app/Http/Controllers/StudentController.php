<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Classroom;
use App\Models\Parint;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('classroom')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.students.index', ['students' => $students]);
    }
    public function create()
    {
        return view('admin.students.create', [
            'classrooms' => Classroom::all(),
            'parints' => Parint::all()
        ]);
    }
    public function show(Student $student)
    {
        return view('admin.students.show', ['student' => $student]);
    }
    public function store(StudentRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('123456789'),
            'role' => 'student',
        ]);


        $valedated = $request->validated();

        $post = new Student($valedated);
        $post->user_id = $user->id;

        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $path = $image->store('Students', 'public');
            $post->image = $path;
        }
        $post->save();

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully');
    }
    public function edit(Student $student)
    {
        return view('admin.students.edit', [
            'classrooms' => Classroom::all(),
            'student' => $student,
            'parints' => Parint::all()
        ]);
    }
    public function update(StudentRequest $request, Student $student)
    {
        $validated = $request->validated();
        

        $student->update($validated);
        $student->save();

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully');
    }
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully');
    }
}
