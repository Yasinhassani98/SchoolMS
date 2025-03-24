<?php

namespace App\Http\Controllers\parent;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Mark;
use App\Models\Parint;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class dashboardController extends Controller
{
    public function dashboard()
    {
        $User_Id = Auth::user();
        $Parent = Parint::where('user_id', $User_Id->id)->first();

        // Get all children of the parent
        $children = Student::where('parint_id', $Parent->id)->get();

        // Count male and female children
        $maleCount = $children->where('gender', 'male')->count();
        $femaleCount = $children->where('gender', 'female')->count();

        // Get upcoming birthdays (children whose birthdays are within the next 30 days)
        $today = now();
        $upcomingBirthdays = $children->filter(function($child) use ($today) {
            $birthday = \Carbon\Carbon::parse($child->date_of_birth);
            $nextBirthday = $birthday->copy()->year($today->year);

            // If the birthday has already occurred this year, look at next year's birthday
            if ($nextBirthday->isPast()) {
                $nextBirthday->addYear();
            }

            // Check if birthday is within the next 30 days
            return $nextBirthday->diffInDays($today) <= 30;
        });

        // Get average marks for all children
        $childrenWithAverages = [];
        foreach ($children as $child) {
            $marks = Mark::where('student_id', $child->id)->get();
            $sum = $marks->sum('mark');
            $count = $marks->count();
            $average = $count > 0 ? $sum / $count : 0;

            $childrenWithAverages[] = [
                'student' => $child,
                'average' => $average
            ];
        }

        return view('parent.dashboard', compact('children', 'maleCount', 'femaleCount', 'upcomingBirthdays', 'childrenWithAverages'));
    }
    public function children()
    {
        $User_Id = Auth::user();
        $Parent = Parint::where('user_id', $User_Id->id)->first();
        $children = Student::where('parint_id', $Parent->id)->get();
        return view('parent.children', compact('children'));
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
