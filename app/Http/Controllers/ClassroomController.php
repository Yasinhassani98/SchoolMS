<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Level;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::all();
        return view('classrooms.index', compact('classrooms'));
    }
    public function create()
    {
        $levels = Level::all();
        return view('classrooms.create', compact('levels'));
    }
    public function store(Request $request)
    {
        $valedated = $request->validate([
            'level_id' => 'required|exists:Levels,id',
            'name' => 'required'
        ]);
        Classroom::create($valedated);
        return redirect()->route('classrooms.index')->with('success', 'The Classroom is created');
    }
    public function edit(Classroom $classroom)
    {
        $levels = Level::all();
        return view('classrooms.edit', compact('classroom', 'levels'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'level_id' => 'required|exists:Levels,id',
            'name' => 'required'
        ]);
        $classroom->update($validated);
        return redirect()->route('classrooms.index')->with('success', 'The Classroom is updated');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('classrooms.index')->with('success', 'The Classroom is deleted');
    }
}
