<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Level;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::paginate(10);
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
            'name' => 'required|min:3|max:255'
        ]);
        Classroom::create($valedated);
        return redirect()->route('classrooms.index')->with('success', 'Classroom created successfully');
    }
    public function edit(Classroom $classroom)
    {
        $levels = Level::all();
        return view('classrooms.edit', compact('classroom', 'levels'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'level_id' => 'required|exists:Levels,id,'. $classroom->id,
            'name' => 'required|min:3|max:255'
        ]);
        $classroom->update($validated);
        return redirect()->route('classrooms.index')->with('success', 'Classroom updated successfully');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('classrooms.index')->with('success', 'Classroom deleted successfully');
    }
}
