<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view-any', Classroom::class);
        $teacherId = Auth::user()->teacher->id;
        $classrooms = Classroom::whereHas('teachers', function($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->with('level')->paginate(10);
        return view('teacher.classrooms.index', compact('classrooms'));
    }

    
}
