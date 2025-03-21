<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Subject::class);
        $teacherId = Auth::user()->teacher->id;
        $subjects = Subject::whereHas('teachers', function($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->with('level')->paginate(10);
        return view('teacher.subjects.index', compact('subjects'));
    }

}
