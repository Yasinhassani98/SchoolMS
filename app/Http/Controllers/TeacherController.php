<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ResponseNotification;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::orderby('created_at', 'desc')->paginate(10);
        return view('admin.teachers.index', ['teachers' => $teachers]);
    }
    
    public function create()
    {
        return view('admin.teachers.create', [
            'classrooms' => Classroom::with('level')->get(),
            'subjects' => Subject::with('level')->get()
        ]);
    }
    
    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', ['teacher' => $teacher]);
    }
    
    public function store(TeacherRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole('teacher');

        $teacher = new Teacher([
            ...$request->except('image', 'classroom_ids', 'subject_ids', 'email', 'password', 'password_confirmation'),
        ]);
        
        $teacher->user_id = $user->id;
        
        if ($request->hasFile('image')) {
            $teacher->image = $request->file('image')->store('Teachers', 'public');
        }
        
        $teacher->save();

        if ($request->filled('classroom_ids')) {
            $classroom_ids = array_filter(explode(',', $request->classroom_ids));
            $teacher->classrooms()->attach($classroom_ids);
        }
        
        if ($request->filled('subject_ids')) {
            $subject_ids = array_filter(explode(',', $request->subject_ids));
            $teacher->subjects()->attach($subject_ids);
        }
        Auth::user()->notify(new ResponseNotification('success', 'Teacher created successfully'));
        return redirect()->route('admin.teachers.index');
    }
    
    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', [
            'teacher' => $teacher,
            'classrooms' => Classroom::with('level')->get(),
            'subjects' => Subject::with('level')->get()
        ]);
    }
    
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'image' => 'nullable|image',
            'name' => 'required|min:3|max:255',
            'gender' => 'required|in:male,female',
            'classroom_ids' => 'nullable|string',
            'subject_ids' => 'nullable|string',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'password' => 'nullable|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'hiring_date' => 'nullable|date',
            'date_of_birth' => 'nullable|date',
            'specialization' => 'nullable|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        
        // Update user information
        $user = User::findOrFail($teacher->user_id);
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => !empty($validated['password']) 
                ? Hash::make($validated['password']) 
                : $user->password,
        ]);
        
        // Remove fields that belong to user model
        $teacherData = collect($validated)
            ->except(['email', 'password', 'password_confirmation', 'classroom_ids', 'subject_ids'])
            ->toArray();
        
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
                Storage::disk('public')->delete($teacher->image);
            }
            
            $teacherData['image'] = $request->file('image')->store('Teachers', 'public');
        }
    
        $teacher->update($teacherData);

        if ($request->filled('classroom_ids')) {
            $classroom_ids = array_filter(explode(',', $request->classroom_ids));
            $teacher->classrooms()->sync($classroom_ids);
        } else {
            $teacher->classrooms()->detach();
        }
        
        if ($request->filled('subject_ids')) {
            $subject_ids = array_filter(explode(',', $request->subject_ids));
            $teacher->subjects()->sync($subject_ids);
        } else {
            $teacher->subjects()->detach();
        }
        Auth::user()->notify(new ResponseNotification('success', 'Teacher updated successfully'));

        return redirect()->route('admin.teachers.index');
    }
    
    public function destroy(Teacher $teacher)
    {
        if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
            Storage::disk('public')->delete($teacher->image);
        }

        $user = User::findorfail($teacher->user_id);
        $user->delete();
        
        Auth::user()->notify(new ResponseNotification('success', 'Teacher deleted successfully'));

        return redirect()->route('admin.teachers.index');
    }
}
