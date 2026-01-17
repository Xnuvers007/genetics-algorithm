<?php

namespace App\Http\Controllers;

use App\Models\AcademicGrade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcademicGradeController extends Controller
{
    public function index(Request $request)
    {
        $query = AcademicGrade::with(['student', 'subject', 'teacher']);

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        $grades = $query->latest()->paginate(20);

        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        $students = Student::where('status', 'aktif')->get();
        $subjects = Subject::where('category', 'akademik')->get();

        return view('grades.create', compact('students', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|in:Ganjil,Genap',
            'academic_year' => 'required|string',
            'daily_score' => 'required|numeric|min:0|max:100',
            'midterm_score' => 'required|numeric|min:0|max:100',
            'final_score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string'
        ]);

        $validated['teacher_id'] = Auth::id();

        AcademicGrade::create($validated);

        return redirect()->route('grades.index')
            ->with('success', 'Nilai akademik berhasil ditambahkan.');
    }

    public function batchInput()
    {
        $classes = \App\Models\ClassRoom::with('students')->get();
        $subjects = Subject::where('category', 'akademik')->get();

        return view('grades.batch-input', compact('classes', 'subjects'));
    }

    public function storeBatch(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|in:Ganjil,Genap',
            'academic_year' => 'required|string',
            'grades' => 'required|array',
            'grades.*.student_id' => 'required|exists:students,id',
            'grades.*.daily_score' => 'required|numeric|min:0|max:100',
            'grades.*.midterm_score' => 'required|numeric|min:0|max:100',
            'grades.*.final_score' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($validated['grades'] as $gradeData) {
            AcademicGrade::updateOrCreate(
                [
                    'student_id' => $gradeData['student_id'],
                    'subject_id' => $validated['subject_id'],
                    'semester' => $validated['semester'],
                    'academic_year' => $validated['academic_year']
                ],
                [
                    'daily_score' => $gradeData['daily_score'],
                    'midterm_score' => $gradeData['midterm_score'],
                    'final_score' => $gradeData['final_score'],
                    'teacher_id' => Auth::id()
                ]
            );
        }

        return redirect()->route('grades.index')
            ->with('success', 'Input nilai batch berhasil untuk ' . count($validated['grades']) . ' siswa.');
    }
}
