<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GeneticAlgorithmController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AcademicGradeController;
use App\Http\Controllers\NonAcademicRecordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ClassRoomController;



Route::get('/', function () {
    return redirect()->route('login');
    // return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Students (Admin & Teachers only)
    Route::middleware(['role:admin,guru,wali_kelas'])->group(function () {
        Route::resource('students', StudentController::class);
        Route::get('students/{student}/grades', [StudentController::class, 'grades'])->name('students.grades');
    });

    // Classes
    Route::middleware(['role:admin,wali_kelas'])->group(function () {
        Route::resource('classes', ClassRoomController::class);
    });

    // Academic Grades (Teachers only)
    Route::middleware(['role:admin,guru,wali_kelas'])->group(function () {
        Route::get('grades', [AcademicGradeController::class, 'index'])->name('grades.index');
        Route::get('grades/create', [AcademicGradeController::class, 'create'])->name('grades.create');
        Route::post('grades', [AcademicGradeController::class, 'store'])->name('grades.store');
        Route::get('grades/batch', [AcademicGradeController::class, 'batchInput'])->name('grades.batch');
        Route::post('grades/batch', [AcademicGradeController::class, 'storeBatch'])->name('grades.batch.store');
        Route::get('grades/{grade}/edit', [AcademicGradeController::class, 'edit'])->name('grades.edit');
        Route::put('grades/{grade}', [AcademicGradeController::class, 'update'])->name('grades.update');
        Route::delete('grades/{grade}', [AcademicGradeController::class, 'destroy'])->name('grades.destroy');
    });

    // Non-Academic Records
    Route::middleware(['role:admin,guru,wali_kelas'])->group(function () {
        Route::resource('non-academic', NonAcademicRecordController::class);
    });

    // Genetic Algorithm (Admin & Homeroom Teachers)
    Route::middleware(['role:admin,wali_kelas'])->group(function () {
        Route::get('ga', [GeneticAlgorithmController::class, 'index'])->name('ga.index');
        Route::get('ga/settings', [GeneticAlgorithmController::class, 'settings'])->name('ga.settings');
        Route::put('ga/settings', [GeneticAlgorithmController::class, 'updateSettings'])->name('ga.settings.update');
        Route::post('ga/execute', [GeneticAlgorithmController::class, 'execute'])->name('ga.execute');
        Route::get('ga/result/{id}', [GeneticAlgorithmController::class, 'viewResult'])->name('ga.result');
        Route::get('ga/statistics', [GeneticAlgorithmController::class, 'statistics'])->name('ga.statistics');
    });

    // Reports
    Route::middleware(['role:admin,guru,wali_kelas'])->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/student/{student}', [ReportController::class, 'studentReport'])->name('reports.student');
        Route::get('reports/class/{class}', [ReportController::class, 'classReport'])->name('reports.class');
    });

    // Student can view their own reports
    Route::middleware(['role:siswa'])->group(function () {
        Route::get('my-report', [ReportController::class, 'myReport'])->name('reports.my');
        Route::get('my-report/download', [ReportController::class, 'downloadMyReport'])->name('reports.my.download');
    });

});

require __DIR__.'/auth.php';



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//     // Genetic Algorithm routes
// });

// Route::view('/offline', 'offline');

// require __DIR__.'/auth.php';
