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
        $students = Student::with(['classroom','parint'])->orderBy('created_at', 'desc')->paginate(10);
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
            'password' => Hash::make($request->password),
        ])->assignRole('student');


        $valedated = $request->validated();

        $student = new Student($valedated);
        $student->user_id = $user->id;

        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $path = $image->store('Students', 'public');
            $student->image = $path;
        }
        $student->save();

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
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'password' => 'nullable|min:6|confirmed',
            'classroom_id' => 'required|exists:classrooms,id',
            'parint_id' => 'required|exists:parints,id',
            'Phone' => 'nullable|string|max:20',
            'enrollment_date' => 'nullable|date',
            'address' => 'nullable|max:255',
            'date_of_birth' => 'nullable|date',
            'image' => 'nullable|image',
            'status' => 'required|in:active,inactive'
        ]);
    
        // Update user information
        $user = User::findOrFail($student->user_id);
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => !empty($validated['password']) 
                ? Hash::make($validated['password']) 
                : $user->password,
        ]);
        
        // Remove fields that belong to user model
        $studentData = collect($validated)
            ->except(['email', 'password', 'password_confirmation'])
            ->toArray();
        
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($student->image && Storage::disk('public')->exists($student->image)) {
                Storage::disk('public')->delete($student->image);
            }
            
            $studentData['image'] = $request->file('image')->store('Students', 'public');
        }
    
        $student->update($studentData);
    
        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student updated successfully');
    }
    public function destroy(Student $student)
    {
        if ($student->image && Storage::disk('public')->exists($student->image)) {
            Storage::disk('public')->delete($student->image);
        }

        $user = User::findorfail($student->user_id);
        $user->delete();
        
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully');
    }
}
