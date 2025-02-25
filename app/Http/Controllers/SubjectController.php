<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        $counter = 1;
        return view('subjects.index', compact('subjects', 'counter'));
    }
    public function create()
    {
        $levels = \App\Models\Level::all();
        return view('subjects.create', compact('levels'));
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
            ->route('subjects.index')
            ->with('success', 'Subject created successfully');
    }
    public function show(Subject $subject)
    {
        return view('subjects.show', ['subject' => $subject]);
    }
    public function edit(Subject $subject)
    {
        // dd($subject);
        $levels = \App\Models\Level::all();
        return view('subjects.edit', ['subject' => $subject, 'levels' => $levels]);
    }
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'level_id' => 'sometimes|required|exists:levels,id',
            'description' => 'sometimes|required|string|min:3|max:255',
            'type' => 'required|in:required,optional',
        ]);
        $subject->update($request->all());



        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject updated successfully');
    }
    public function destroy(Subject $subject)
    {
        if ($subject->delete()) {
            return view('subjects.index')
                ->with('success', 'Subject deleted successfully');
        } else {
            return redirect()
                ->back()
                ->with('success', 'Failed to delete subject');
        }
    }
}
