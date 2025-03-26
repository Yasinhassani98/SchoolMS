<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ResponseNotification;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('level')->orderBy('created_at','desc')->paginate(10);
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
            'description' => 'nullable|string|min:3|max:255',
            'file' => 'nullable|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:20480', // 20MB, more file types
        ]);
$subject = new Subject(
[
    'name' => $validatedData['name'],
    'level_id' => $validatedData['level_id'],
    'description' => $validatedData['description'] ?? null,
]
);
        // Handle file upload first
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_path = $file->store('Subjects', 'public');
            // $validatedData['file'] = $file_path;
            $subject->file = $file_path;
        }
        $subject->save();

        Auth::user()->notify(new ResponseNotification('success', 'Subject created successfully'));


        return redirect()
            ->route('admin.subjects.index');
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
            'description' => 'nullable|string|min:3|max:255',
        ]);
        $subject->update($request->all());

        Auth::user()->notify(new ResponseNotification('success', 'Subject updated successfully'));

        return redirect()
            ->route('admin.subjects.index');
    }
    public function destroy(Subject $subject)
    {
        $subject->delete();
        Auth::user()->notify(new ResponseNotification('success', 'Subject deleted successfully'));
        return redirect()->route('admin.subjects.index');
    }
}
