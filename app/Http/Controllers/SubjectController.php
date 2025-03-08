<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('level')->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }
    public function create()
    {
        $levels = Level::all();
        return view('admin.subjects.create', compact('levels'));
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'level_id' => 'required|exists:levels,id',
            'description' => 'required|string',
            'type' => 'required|in:required,optional',
        ]);
        Subject::create($validatedData);


        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Subject created successfully');
    }
    public function show(Subject $subject)
    {
        return view('admin.subjects.show', ['subject' => $subject]);
    }
    public function edit(Subject $subject)
    {
        $levels = Level::all();
        return view('admin.subjects.edit', ['subject' => $subject, 'levels' => $levels]);
    }
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level_id' => 'required|exists:levels,id',
            'description' => 'required|string|min:3|max:255',
            'type' => 'required|in:required,optional',
        ]);
        $subject->update($request->all());



        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully');
    }
    public function destroy(Subject $subject)
    {
        if ($subject->delete()) {
            return view('admin.subjects.index')
                ->with('success', 'Subject deleted successfully');
        } else {
            return redirect()
                ->back()
                ->with('success', 'Failed to delete subject');
        }
    }
}
