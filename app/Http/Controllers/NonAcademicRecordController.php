<?php

namespace App\Http\Controllers;

use App\Models\NonAcademicRecord;
use App\Models\Student;
use Illuminate\Http\Request;

class NonAcademicRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = NonAcademicRecord::with('student');
        
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        $records = $query->latest()->paginate(20);
        
        return view('non-academic.index', compact('records'));
    }

    public function create()
    {
        $students = Student::where('status', 'aktif')->orderBy('name')->get();
        return view('non-academic.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'activity_name' => 'required|string|max:100',
            'category' => 'required|in:Ekstrakurikuler,Prestasi,Sikap,Kehadiran,Lainnya',
            'semester' => 'required|in:Ganjil,Genap',
            'academic_year' => 'required|string',
            'score' => 'required|numeric|min:0|max:100',
            'achievement' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);
        
        NonAcademicRecord::create($validated);
        
        return redirect()->route('non-academic.index')
            ->with('success', 'Rekam non-akademik berhasil ditambahkan.');
    }

    public function show(NonAcademicRecord $nonAcademic)
    {
        return view('non-academic.show', compact('nonAcademic'));
    }

    public function edit(NonAcademicRecord $nonAcademic)
    {
        $students = Student::where('status', 'aktif')->orderBy('name')->get();
        return view('non-academic.edit', compact('nonAcademic', 'students'));
    }

    public function update(Request $request, NonAcademicRecord $nonAcademic)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'activity_name' => 'required|string|max:100',
            'category' => 'required|in:Ekstrakurikuler,Prestasi,Sikap,Kehadiran,Lainnya',
            'semester' => 'required|in:Ganjil,Genap',
            'academic_year' => 'required|string',
            'score' => 'required|numeric|min:0|max:100',
            'achievement' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);
        
        $nonAcademic->update($validated);
        
        return redirect()->route('non-academic.index')
            ->with('success', 'Rekam non-akademik berhasil diperbarui.');
    }

    public function destroy(NonAcademicRecord $nonAcademic)
    {
        $nonAcademic->delete();
        
        return redirect()->route('non-academic.index')
            ->with('success', 'Rekam non-akademik berhasil dihapus.');
    }
}
