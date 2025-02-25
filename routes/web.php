<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('content');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::view('base','content');

// Student Routes
Route::resource('students', StudentController::class);

// Teacher Routes
Route::resource('teachers', TeacherController::class);

// Classroom Routes
Route::resource('classrooms', ClassroomController::class);

// Subject Routes
Route::resource('subjects',SubjectController::class);

// Levels Routes
Route::resource('levels',LevelController::class);
require __DIR__.'/auth.php';
