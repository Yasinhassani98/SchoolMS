<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WlcomeController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\parent\dashboardController as ParentDashboardController;
use App\Http\Controllers\ParintController;

use App\Http\Controllers\student\AttendanceController as StudentAttendanceController;
use App\Http\Controllers\student\dashboardController;
use App\Http\Controllers\student\MarkController as StudentMarkController;
use App\Http\Controllers\student\SubjectController as StudentSubjectController;
use App\Http\Controllers\SuperAdminController;

use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Teacher\ClassroomController as TeacherClassroomController;
use App\Http\Controllers\Teacher\MarkController as TeacherMarkController;
use App\Http\Controllers\Teacher\StudentController as TeacherStudentController;
use App\Http\Controllers\Teacher\SubjectController as TeacherSubjectController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
use Spatie\Permission\Models\Role;

Route::get('/test-roles', function () {
    return Role::all();
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin|superadmin'])->prefix('admin/')->as('admin.')->group(function () {
    // Dashboard Route
    Route::get('dashboard',[WlcomeController::class,'adminWelcome'])->name('dashboard');

    // Role and Permission Routes
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('permissions', PermissionController::class)->except(['show']);

    // User Routes
    Route::resource('users', UserController::class)->except(['show']);

    // Student Routes
    Route::resource('students', StudentController::class);

    // Teacher Routes
    Route::resource('teachers', TeacherController::class);

    // Classroom Routes
    Route::resource('classrooms', ClassroomController::class)->except(['show']);

    // Subject Routes
    Route::resource('subjects', SubjectController::class);

    // Levels Routes
    Route::resource('levels', LevelController::class);

    // Marks Routes
    Route::resource('marks', MarkController::class);

    // Academic Year Routes
    Route::patch('academic-years/set-current/{academicYear}', [AcademicYearController::class, 'setCurrent'])->name('academic-years.set-current');
    Route::resource('academic-years', AcademicYearController::class)->except(['show']);

    // Parint Routes
    Route::resource('parents', ParintController::class);

    // Attendance Routes
    Route::resource('attendances', AttendanceController::class)->except(['show']);
});


Route::middleware(['auth', 'role:student'])->prefix('student/')->as('student.')->group(function () {
    // Dashboard Route
    Route::get('dashboard',[WlcomeController::class,'studentWelcome'])->name('dashboard');

    // Attendance Routes
    Route::resource('attendances', StudentAttendanceController::class)->only(['index']);

    // Subject Routes
    Route::resource('subjects', StudentSubjectController::class)->only(['index','show']);

    // Marks Routes
    Route::resource('marks', StudentMarkController::class)->only(['index']);
});

Route::middleware(['auth', 'role:parent'])->prefix('parent/')->as('parent.')->group(function () {
    // Dashboard Route
    Route::get('dashboard',[ParentDashboardController::class,'dashboard'])->name('dashboard');
    // Children Routes
    Route::get('children',[ParentDashboardController::class,'children'])->name('children');
    // Students Routes
    Route::get('children/{student}',[ParentDashboardController::class,'show'])->name('children.show');
});


Route::middleware(['auth', 'role:teacher'])->prefix('teacher/')->as('teacher.')->group(function () {
    // Dashboard Route
    Route::get('dashboard',[WlcomeController::class,'teacherWelcome'])->name('dashboard');
    // Attendance Routes
    Route::resource('attendances', TeacherAttendanceController::class)->except(['show']);
    // Marks Routes
    Route::resource('marks', TeacherMarkController::class)->except(['show']);
    // Students Routes
    Route::get('students',[TeacherStudentController::class,'index'])->name('students.index');
    Route::get('students/{student}',[TeacherStudentController::class,'show'])->name('students.show');
    // Classrooms Routes
    Route::get('classrooms',[TeacherClassroomController::class,'index'])->name('classrooms.index');
    // Subjects Routes
    Route::get('subjects',[TeacherSubjectController::class,'index'])->name('subjects.index');

});
require __DIR__ . '/auth.php';
