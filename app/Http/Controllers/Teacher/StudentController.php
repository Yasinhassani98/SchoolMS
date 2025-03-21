<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Student::class);
        $teacherId = Auth::user()->teacher()->first()->id;
        $classroom_ids = Classroom::whereHas('teachers', function($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->pluck('id')->toArray();
        $students = Student::whereIn('classroom_id', $classroom_ids)->paginate(10);
        return view('teacher.students.index', compact('students'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        Gate::authorize('view', $student);
        return view('teacher.students.show', compact('student'));
    }

}
