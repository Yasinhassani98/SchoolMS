<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ResponseNotification;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->paginate(10);
        return view('admin.academic-years.index', compact('academicYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.academic-years.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:academic_years',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'sometimes|boolean',
            'description' => 'nullable|string|max:255',
        ]);

        // If this is set as current, unset any other current academic year
        if (isset($validated['is_current']) && $validated['is_current']) {
            DB::table('academic_years')->update(['is_current' => false]);
        }

        AcademicYear::create($validated);
        Auth::user()->notify(new ResponseNotification('success', 'Academic Year Created Successfully'));
        return redirect()->route('admin.academic-years.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academicYear)
    {
        return view('admin.academic-years.edit', compact('academicYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicYear $academicYear)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:academic_years,name,' . $academicYear->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'sometimes|boolean',
            'description' => 'nullable|string|max:255',
        ]);

        // If this is set as current, unset any other current academic year
        if (isset($validated['is_current']) && $validated['is_current']) {
            DB::table('academic_years')->where('id', '!=', $academicYear->id)->update(['is_current' => false]);
        }

        $academicYear->update($validated);
        Auth::user()->notify(new ResponseNotification('success', 'Academic Year Updated Successfully'));
        return redirect()->route('admin.academic-years.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academicYear)
    {
        // Check if this is the current academic year
        if ($academicYear->is_current) {
            Auth::user()->notify(new ResponseNotification('danger', 'Cannot delete the current academic year.'));
            return redirect()->route('admin.academic-years.index');
        }
        
        try {
            $academicYear->delete();
            Auth::user()->notify(new ResponseNotification('success', 'Academic Year Deleted Successfully'));
            return redirect()->route('admin.academic-years.index');
        } catch (\Exception $e) {
            Auth::user()->notify(new ResponseNotification('danger', 'Cannot delete the academic year. It has related records.'));
            return redirect()->route('admin.academic-years.index');
        }
    }
    
    /**
     * Set an academic year as the current one.
     */
    public function setCurrent(AcademicYear $academicYear)
    {
        DB::table('academic_years')->update(['is_current' => false]);
        $academicYear->update(['is_current' => true]);
        Auth::user()->notify(new ResponseNotification('success', 'Academic Year Set as Current Successfully'));
        return redirect()->route('admin.academic-years.index');
    }
}
