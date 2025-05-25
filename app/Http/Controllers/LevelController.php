<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Notifications\ResponseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::paginate();
        return view('admin.levels.index', ['levels' => $levels]);
    }
    public function create()
    {
        return view('admin.levels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'level' => 'required|numeric|min:0|max:12|unique:levels,level',
            
        ]);

        Level::create($request->all());
        Auth::user()->notify(new ResponseNotification('success', 'Level created successfully'));
        return redirect()->route('admin.levels.index');
    }
    public function edit(Level $level)
    {
        return view('admin.levels.edit', ['level' => $level]);
    }
    public function update(Request $request, Level $level)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'level' => 'required|numeric|min:0|max:12|unique:levels,level,' . $level->id,
        ]);
        $level->update($request->all());
        Auth::user()->notify(new ResponseNotification('success', 'Level updated successfully'));
        return redirect()->route('admin.levels.index');
    }
    public function destroy(Level $level)
    {
        $level->delete();
        Auth::user()->notify(new ResponseNotification('success', 'Level deleted successfully'));
        return redirect()->route('admin.levels.index');
    }
}
