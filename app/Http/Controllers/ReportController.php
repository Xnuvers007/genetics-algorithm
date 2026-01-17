<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\GaResult;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function index()
    {
        $students = Student::with('classRoom')->where('status', 'aktif')->orderBy('name')->get();
        $classes = ClassRoom::orderBy('grade_level')->orderBy('name')->get();
        
        return view('reports.index', compact('students', 'classes'));
    }

    public function myReport(Request $request)
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }
        
        $semester = $request->input('semester', 'Ganjil');
        $academicYear = $request->input('academic_year', '2024/2025');
        
        // Validate semester and academic year format
        if (!in_array($semester, ['Ganjil', 'Genap'])) {
            $semester = 'Ganjil';
        }
        if (!preg_match('/^\d{4}\/\d{4}$/', $academicYear)) {
            $academicYear = '2024/2025';
        }

        $student = Student::with([
            'classRoom',
            'academicGrades' => function($q) use ($semester, $academicYear) {
                $q->where('semester', $semester)
                  ->where('academic_year', $academicYear)
                  ->with('subject');
            },
            'nonAcademicRecords' => function($q) use ($semester, $academicYear) {
                $q->where('semester', $semester)
                  ->where('academic_year', $academicYear);
            }
        ])->findOrFail($student->id);

        $gaResult = GaResult::where('student_id', $student->id)
            ->where('semester', $semester)
            ->where('academic_year', $academicYear)
            ->first();

        return view('reports.my-report', [
            'student' => $student,
            'gaResult' => $gaResult,
            'semester' => $semester,
            'academicYear' => $academicYear
        ]);
    }

    public function downloadMyReport(Request $request)
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        return $this->studentReport($student->id, $request);
    }

    public function studentReport($studentId, Request $request)
    {
        // Validate inputs to prevent injection
        $studentId = (int) $studentId;
        $semester = $request->input('semester', 'Ganjil');
        $academicYear = $request->input('academic_year', '2024/2025');
        
        // Validate semester and academic year format
        if (!in_array($semester, ['Ganjil', 'Genap'])) {
            $semester = 'Ganjil';
        }
        if (!preg_match('/^\d{4}\/\d{4}$/', $academicYear)) {
            $academicYear = '2024/2025';
        }

        $student = Student::with([
            'classRoom',
            'academicGrades' => function($q) use ($semester, $academicYear) {
                $q->where('semester', $semester)
                  ->where('academic_year', $academicYear)
                  ->with('subject');
            },
            'nonAcademicRecords' => function($q) use ($semester, $academicYear) {
                $q->where('semester', $semester)
                  ->where('academic_year', $academicYear);
            }
        ])->findOrFail($studentId);

        // IDOR Protection: Check if user is authorized to view this report
        $user = auth()->user();
        if ($user->isStudent()) {
            $userStudent = $user->student;
            if (!$userStudent || $userStudent->id !== $student->id) {
                abort(403, 'Anda tidak memiliki akses untuk melihat laporan siswa ini.');
            }
        }

        $gaResult = GaResult::where('student_id', $studentId)
            ->where('semester', $semester)
            ->where('academic_year', $academicYear)
            ->first();

        // Sanitize student name and academic year for filename
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $student->name);
        $safeAcademicYear = str_replace(['/', '\\'], '-', $academicYear);

        $pdf = Pdf::loadView('reports.student-report', [
            'student' => $student,
            'gaResult' => $gaResult,
            'semester' => $semester,
            'academicYear' => $academicYear
        ]);

        return $pdf->download("Raport_{$sanitizedName}_{$semester}_{$safeAcademicYear}.pdf");
    }

    public function classReport($classId, Request $request)
    {
        // Validate inputs to prevent injection
        $classId = (int) $classId;
        $semester = $request->input('semester', 'Ganjil');
        $academicYear = $request->input('academic_year', '2024/2025');
        
        // Validate semester and academic year format
        if (!in_array($semester, ['Ganjil', 'Genap'])) {
            $semester = 'Ganjil';
        }
        if (!preg_match('/^\d{4}\/\d{4}$/', $academicYear)) {
            $academicYear = '2024/2025';
        }

        $class = ClassRoom::with([
            'students.gaResults' => function($q) use ($semester, $academicYear) {
                $q->where('semester', $semester)
                  ->where('academic_year', $academicYear);
            }
        ])->findOrFail($classId);

        // Sanitize class name and academic year for filename
        $sanitizedClassName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $class->name);
        $safeAcademicYear = str_replace(['/', '\\'], '-', $academicYear);

        $pdf = Pdf::loadView('reports.class-report', [
            'class' => $class,
            'semester' => $semester,
            'academicYear' => $academicYear
        ])->setPaper('a4', 'landscape');

        return $pdf->download("Laporan_Kelas_{$sanitizedClassName}_{$semester}_{$safeAcademicYear}.pdf");
    }
}
