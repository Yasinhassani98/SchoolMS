<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::paginate();
        return view('levels.index', ['levels' => $levels]);
    }
    public function create()
    {
        return view('levels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'level' => 'required|numeric|min:0|max:12|unique:levels,level',
            
        ]);

        Level::create($request->all());
        return redirect()->route('levels.index')->with('success', 'Level created successfully');
    }
    public function edit(Level $level)
    {
        return view('levels.edit', ['level' => $level]);
    }
    public function update(Request $request, Level $level)
    {
        $request->validate([
            'name' => 'required',
            'level' => 'required|numeric|min:0|max:12|unique:levels,level,' . $level->id,
        ]);
        $level->update($request->all());
        return redirect()->route('levels.index')->with('success', 'Level updated successfully');
    }
    public function destroy(Level $level)
    {
        $level->delete();
        return redirect()->route('levels.index')->with('success', 'Level deleted successfully');
    }
}
