<?php

namespace App\Http\Controllers\parent;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Mark;
use App\Models\Parint;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class dashboardController extends Controller
{
    public function welcome()
    {
        $User_Id = Auth::user();
        $Parent = Parint::where('user_id', $User_Id->id)->first();
        $children = Student::where('parint_id', $Parent->id)->get();
        return view('parent.dashboard', compact('children'));
    }
    public function show(Student $student)
    {
        Gate::authorize('view', $student);

        $subjects = Subject::whereHas('marks', function ($query) use ($student) {
            $query->where('student_id', $student->id);
        })->get();
        $subjectData = [];
        foreach ($subjects as $subject) {
            $mark = Mark::where('student_id', $student->id)
                ->where('subject_id', $subject->id)
                ->first();
            $attendance = Attendance::where('student_id', $student->id)
                ->where('subject_id', $subject->id)
                ->get();
            $teacherName = $mark->teacher->name;

            $subjectData[] = [
                'subject' => $subject->name,
                'mark' => $mark ? $mark->mark : 0,
                'teacher' => $teacherName,
                'attendance_count' => $attendance->count(),
                'present_count' => $attendance->where('status', 'present')->count(),
                'absent_count' => $attendance->where('status', 'absent')->count(),
                'late_count' => $attendance->where('status', 'late')->count(),
            ];
        }
        $sum = 0;
        $count = 0;
        foreach ($subjectData as $subject) {
            if ($subject['mark'] !== null) {
                $sum += $subject['mark'];
                $count++;
            }
        }
        $average = $count > 0 ? $sum / $count : 0;
        return view('parent.child', compact('student', 'subjectData', 'average'));
    }
}
