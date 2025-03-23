<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Level;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WlcomeController extends Controller
{
    public function adminWelcome()
    {
        // Basic statistics
        $studentsCount = Student::count();
        $teachersCount = Teacher::count();
        $classroomsCount = Classroom::count();

        // Get levels with classroom counts
        $levels = Level::withCount('classrooms')->get();

        // Gender distribution
        $maleStudentsCount = Student::where('gender', 'male')->count();
        $femaleStudentsCount = Student::where('gender', 'female')->count();

        // Recent students
        $recentStudents = Student::with('classroom')
            ->latest()
            ->take(5)
            ->get();

        // Recent teachers
        $recentTeachers = Teacher::with('user')->latest()
            ->take(5)
            ->get();

        // Students per level chart data
        $studentsPerLevel = Level::with('classrooms.students')
            ->get()
            ->map(function ($level) {
                return [
                    'level' => $level->name,
                    'count' => $level->classrooms->sum(function ($classroom) {
                        return $classroom->students->count();
                    })
                ];
            });

        // Attendance overview (last 30 days)
        $attendanceOverview = Attendance::where('date', '>=', now()->subDays(30))
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Get attendance data for the last 7 days for chart
        $last7Days = collect();
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Initialize the collection with dates
        for ($i = 6; $i >= 0; $i--) {
            $currentDate = Carbon::now()->subDays($i);
            $dateKey = $currentDate->format('Y-m-d');
            $last7Days->put($dateKey, [
                'date' => $currentDate->format('D'),
                'present' => 0,
                'absent' => 0,
                'late' => 0
            ]);
        }

        $attendanceByDay = Attendance::whereBetween('date', [$startDate, $endDate])
            ->select('date', 'status', DB::raw('count(*) as count'))
            ->groupBy('date', 'status')
            ->orderBy('date')
            ->get();

        // Map attendance records to the collection
        foreach ($attendanceByDay as $record) {
            $dateKey = Carbon::parse($record->date)->format('Y-m-d');
            if ($last7Days->has($dateKey) && in_array($record->status, ['present', 'absent', 'late'])) {
                // Get the current day data
                $dayData = $last7Days->get($dateKey);
                // Update the specific status count
                $dayData[$record->status] = (int)$record->count;
                // Put the updated data back into the collection
                $last7Days->put($dateKey, $dayData);
            }
        }

        // Convert collection to array for JSON encoding
        $last7DaysArray = array_values($last7Days->toArray());

        return view('admin.dashboard', compact(
            'studentsCount',
            'teachersCount',
            'classroomsCount',
            'levels',
            'maleStudentsCount',
            'femaleStudentsCount',
            'recentStudents',
            'recentTeachers',
            'studentsPerLevel',
            'attendanceOverview',
            'last7DaysArray'
        ));
    }

    public function teacherWelcome()
    {
        // Get the authenticated teacher
        $teacher = Auth::user()->teacher()->first();

        if (!$teacher) {
            return redirect()->route('login')->with('error', 'Teacher profile not found');
        }

        // Get classrooms assigned to this teacher
        $classrooms = Classroom::whereHas('teachers', function ($query) use ($teacher) {
            $query->where('teachers.id', $teacher->id);
        })->get();

        $classroomIds = $classrooms->pluck('id')->toArray();

        // Get subjects taught by this teacher
        $subjects = Subject::whereHas('teachers', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->get();

        // Count students in teacher's classes
        $studentsCount = Student::whereIn('classroom_id', $classroomIds)->count();

        // Gender distribution
        $maleStudentsCount = Student::whereIn('classroom_id', $classroomIds)
            ->where('gender', 'male')->count();

        $femaleStudentsCount = Student::whereIn('classroom_id', $classroomIds)
            ->where('gender', 'female')->count();

        // Recent attendance statistics (last 30 days)
        $attendanceStats = Attendance::where('teacher_id', $teacher->id)
            ->where('date', '>=', now()->subDays(30))
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Get attendance data for the last 7 days for chart
        $last7Days = collect();
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Initialize the collection with dates
        for ($i = 6; $i >= 0; $i--) {
            $currentDate = Carbon::now()->subDays($i);
            $dateKey = $currentDate->format('Y-m-d');
            $last7Days->put($dateKey, [
                'date' => $currentDate->format('D'),
                'present' => 0,
                'absent' => 0,
                'late' => 0
            ]);
        }

        // Get attendance records for the date range
        $attendanceByDay = Attendance::where('teacher_id', $teacher->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->select('date', 'status', DB::raw('count(*) as count'))
            ->groupBy('date', 'status')
            ->orderBy('date')
            ->get();

        // Map attendance records to the collection
        foreach ($attendanceByDay as $record) {
            $dateKey = Carbon::parse($record->date)->format('Y-m-d');
            if ($last7Days->has($dateKey) && in_array($record->status, ['present', 'absent', 'late'])) {
                // Get the current day data
                $dayData = $last7Days->get($dateKey);
                // Update the specific status count
                $dayData[$record->status] = (int)$record->count;
                // Put the updated data back into the collection
                $last7Days->put($dateKey, $dayData);
            }
        }

        // Convert collection to array and ensure all dates are included
        $last7DaysArray = array_values($last7Days->toArray());

        // Get recent marks data
        $recentMarks = Mark::where('teacher_id', $teacher->id)
            ->with(['student', 'subject', 'classroom'])
            ->latest()
            ->take(5)
            ->get();

        // Calculate average marks by subject
        $marksBySubject = Mark::where('teacher_id', $teacher->id)
            ->select('subject_id', DB::raw('AVG(mark) as average_mark'))
            ->groupBy('subject_id')
            ->get()
            ->map(function ($item) {
                $subject = Subject::find($item->subject_id);
                return [
                    'subject' => $subject ? $subject->name : 'Unknown',
                    'average' => round($item->average_mark, 1)
                ];
            });

        // Get upcoming birthdays (next 30 days)
        $today = Carbon::now();
        $thirtyDaysLater = $today->copy()->addDays(30);

        // Get students whose birthdays fall within the next 30 days
        $upcomingBirthdays = Student::whereIn('classroom_id', $classroomIds)
            ->whereNotNull('date_of_birth')
            ->get()
            ->map(function ($student) use ($today) {
                $birthdate = Carbon::parse($student->date_of_birth);
                $nextBirthday = Carbon::parse($student->date_of_birth)->setYear($today->year);

                if ($nextBirthday->isPast()) {
                    $nextBirthday->addYear();
                }

                // Calculate days until next birthday
                $student->days_until = max(0, $today->diffInDays($nextBirthday, false));

                // Format next birthday date
                $student->next_birthday = $nextBirthday->format('M d');

                // Calculate age they will be on their next birthday
                $student->age = $today->year - $birthdate->year ;

                return $student;
            })
            ->filter(function ($student) {
                return $student->days_until <= 30;
            })
            ->sortBy('days_until')
            ->take(5)
            ->values();

        return view('teacher.dashboard', compact(
            'teacher',
            'classrooms',
            'subjects',
            'studentsCount',
            'maleStudentsCount',
            'femaleStudentsCount',
            'attendanceStats',
            'last7DaysArray',
            'recentMarks',
            'marksBySubject',
            'upcomingBirthdays'
        ));
    }

    public function studentWelcome()
    {
        return view('student.dashboard');
    }
}
