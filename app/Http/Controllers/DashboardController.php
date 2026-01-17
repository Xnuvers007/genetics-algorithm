<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\User;
use App\Models\GaResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Different dashboard for different roles
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isTeacher() || $user->isHomeroomTeacher()) {
            return $this->teacherDashboard();
        } elseif ($user->isStudent()) {
            return $this->studentDashboard();
        }
    }

    protected function adminDashboard()
    {
        $data = [
            'total_students' => Student::where('status', 'aktif')->count(),
            'total_classes' => ClassRoom::count(),
            'total_teachers' => User::whereIn('role', ['guru', 'wali_kelas'])->count(),
            'recent_results' => GaResult::with('student')
                ->latest()
                ->take(10)
                ->get(),
            'classification_stats' => GaResult::selectRaw('classification, COUNT(*) as count')
                ->groupBy('classification')
                ->get()
        ];

        return view('dashboard.admin', $data);
    }

    protected function teacherDashboard()
    {
        $user = Auth::user();
        
        $data = [
            'my_classes' => $user->homeroomClasses,
            'total_students' => Student::whereHas('classRoom', function($q) use ($user) {
                $q->where('homeroom_teacher_id', $user->id);
            })->count(),
            'recent_grades' => $user->academicGrades()
                ->with(['student', 'subject'])
                ->latest()
                ->take(10)
                ->get()
        ];

        return view('dashboard.teacher', $data);
    }

    protected function studentDashboard()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            return redirect()->route('profile.edit')
                ->with('error', 'Profil siswa belum lengkap.');
        }

        $currentSemester = 'Ganjil'; // Get from settings
        $currentYear = '2024/2025';

        $data = [
            'student' => $student,
            'academic_grades' => $student->academicGrades()
                ->with('subject')
                ->where('semester', $currentSemester)
                ->where('academic_year', $currentYear)
                ->get(),
            'non_academic_records' => $student->nonAcademicRecords()
                ->where('semester', $currentSemester)
                ->where('academic_year', $currentYear)
                ->get(),
            'ga_result' => $student->gaResults()
                ->where('semester', $currentSemester)
                ->where('academic_year', $currentYear)
                ->first()
        ];

        return view('dashboard.student', $data);
    }
}