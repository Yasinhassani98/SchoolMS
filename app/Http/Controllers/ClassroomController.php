<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Level;
use App\Notifications\ResponseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::paginate(10);
        return view('admin.classrooms.index', compact('classrooms'));
    }
    public function create()
    {
        $levels = Level::all();
        return view('admin.classrooms.create', compact('levels'));
    }
    public function store(Request $request)
    {
        $valedated = $request->validate([
            'level_id' => 'required|exists:Levels,id',
            'name' => 'required|max:255'
        ]);
        Classroom::create($valedated);
        Auth::user()->notify(new ResponseNotification('success', 'Classroom created successfully'));
        return redirect()->route('admin.classrooms.index');
    }
    public function edit(Classroom $classroom)
    {
        $levels = Level::all();
        return view('admin.classrooms.edit', compact('classroom', 'levels'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'level_id' => 'required|exists:levels,id',
            'name' => 'required|max:255'
        ]);
        $classroom->update($validated);
        Auth::user()->notify(new ResponseNotification('success', 'Classroom updated successfully'));
        return redirect()->route('admin.classrooms.index');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        Auth::user()->notify(new ResponseNotification('success', 'Classroom deleted successfully'));
        return redirect()->route('admin.classrooms.index');
    }
}
