<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\MarkRequest;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Mark::class);

        $teacherId = Auth::user()->teacher()->first()->id;

        $marks = Mark::where('teacher_id', $teacherId)->with([
            'subject',
            'student',
            'academicYear',
            'teacher',
        ])->orderBy('created_at', 'desc')->paginate(10);

        return view('teacher.marks.index', compact('marks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Mark::class);

        $teacherId = Auth::user()->teacher()->first()->id;

        $classrooms = Classroom::whereHas('teachers', function ($query) use ($teacherId) {
            $query->where('teachers.id', $teacherId);
        })->get();

        $subjects = Subject::whereHas('teachers', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();

        // If teacher has no assigned classrooms, provide empty collection for students
        $students = $classrooms->isEmpty()
            ? collect()
            : Student::whereIn('classroom_id', $classrooms->pluck('id'))
            ->select('id', 'name', 'classroom_id')
            ->orderBy('name')
            ->get();

        return view('teacher.marks.create', compact('students', 'subjects', 'classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarkRequest $request)
    {
        Gate::authorize('create', Mark::class);

        try {
            DB::beginTransaction();


            $academicYear = AcademicYear::where('is_current', true)->firstOrFail();
            $teacherId = Auth::user()->teacher()->first()->id;

            // Check for duplicate marks
            $existingMarks = Mark::where([
                'subject_id' => $request->subject_id,
                'academic_year_id' => $academicYear->id,
            ]);

            // Process multiple students
            $studentIds = $request->student_ids;
            $markValues = $request->mark_values;

            // Check for existing records for these students
            $duplicateStudents = $existingMarks->whereIn('student_id', $studentIds)->pluck('student_id')->toArray();

            if (!empty($duplicateStudents)) {
                $duplicateNames = Student::whereIn('id', $duplicateStudents)->pluck('name')->implode(', ');
                return back()->withInput()->withErrors([
                    'general' => "Marks already exist for: {$duplicateNames} for this subject."
                ]);
            }

            // Create mark records for each student
            $records = [];
            for ($i = 0; $i < count($studentIds); $i++) {
                // Skip if mark value is empty or not provided
                if (!isset($markValues[$i]) || $markValues[$i] === '') {
                    continue;
                }

                $records[] = [
                    'teacher_id' => $teacherId,
                    'student_id' => $studentIds[$i],
                    'classroom_id' => $request->classroom_id,
                    'subject_id' => $request->subject_id,
                    'academic_year_id' => $academicYear->id,
                    'mark' => $markValues[$i],
                    'note' => $request->note,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $student = Student::findOrFail($studentIds[$i]);
                $parent = $student->parent;
                $subject = Subject::find($request->subject_id);
                $notification = new GeneralNotification(
                    'New Mark Added',
                    "A new mark has been added for {$subject->name}.",
                    'info'
                );
                $student->user->notify($notification);
                if ($parent) {
                    $parent->user->notify($notification);
                }
            }

            if (empty($records)) {
                return back()->withInput()->withErrors([
                    'general' => 'No valid marks were provided.'
                ]);
            }

            // Use bulk insert for better performance
            Mark::insert($records);

            DB::commit();

            return redirect()->route('teacher.marks.index')
                ->with('success', 'Mark records created successfully for ' . count($records) . ' students.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to record mark: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mark $mark)
    {
        Gate::authorize('update', $mark);

        if ($mark->teacher_id !== Auth::user()->teacher()->first()->id) {
            return redirect()->route('teacher.marks.index')
                ->with('error', 'You are not authorized to edit this mark.');
        }

        $teacherId = Auth::user()->teacher()->first()->id;

        $classrooms = Classroom::whereHas('teachers', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();

        $subjects = Subject::whereHas('teachers', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();

        $students = Student::where('classroom_id', $mark->classroom_id)->get();

        return view('teacher.marks.edit', compact('mark', 'classrooms', 'subjects', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MarkRequest $request, Mark $mark)
    {
        Gate::authorize('update', $mark);

        try {
            DB::beginTransaction();

            // Check if updating would create a duplicate
            $existingMark = Mark::where([
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'academic_year_id' => $mark->academic_year_id,
            ])
                ->where('id', '!=', $mark->id)
                ->first();

            if ($existingMark) {
                return redirect()->back()
                    ->with('error', 'Another mark for this student and subject already exists.')
                    ->withInput();
            }

            $mark->update([
                'student_id' => $request->student_id,
                'classroom_id' => $request->classroom_id,
                'subject_id' => $request->subject_id,
                'mark' => $request->mark,
                'note' => $request->note,
            ]);
            // Notification
            $student = Student::findOrFail($request->student_id);
            $parent = $student->parent;
            $subject = Subject::find($request->subject_id);
            $notification = new GeneralNotification(
                'Mark Updated',
                "Your mark has been updated for {$subject->name}.",
                'info'
            );
            $student->user->notify($notification);
            $parent->user->notify($notification);


            DB::commit();

            return redirect()->route('teacher.marks.index')
                ->with('success', 'Mark updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update mark: ' . $e->getMessage())
                ->withInput();
                
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mark $mark)
    {
        Gate::authorize('delete', $mark);
        $mark->delete();
        return redirect()->route('teacher.marks.index')
            ->with('success', 'Mark deleted successfully.');
    }
}
