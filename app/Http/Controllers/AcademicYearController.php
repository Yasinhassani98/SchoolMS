<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return redirect()->route('admin.academic-years.index')
            ->with('success', 'Academic year created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicYear $academicYear)
    {
        return view('admin.academic-years.show', compact('academicYear'));
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

        return redirect()->route('admin.academic-years.index')
            ->with('success', 'Academic year updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academicYear)
    {
        // Check if this is the current academic year
        if ($academicYear->is_current) {
            return redirect()->route('admin.academic-years.index')
                ->with('error', 'Cannot delete the current academic year.');
        }

        // Check if academic year has related records
        // This would need to be expanded based on your actual relationships
        // For example: if ($academicYear->classes->count() > 0)
        
        try {
            $academicYear->delete();
            return redirect()->route('admin.academic-years.index')
                ->with('success', 'Academic year deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.academic-years.index')
                ->with('error', 'Cannot delete academic year. It has related records.');
        }
    }
    
    /**
     * Set an academic year as the current one.
     */
    public function setCurrent(AcademicYear $academicYear)
    {
        DB::table('academic_years')->update(['is_current' => false]);
        $academicYear->update(['is_current' => true]);
        
        return redirect()->route('admin.academic-years.index')
            ->with('success', 'Current academic year updated successfully.');
    }
}
