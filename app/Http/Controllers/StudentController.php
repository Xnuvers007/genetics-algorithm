<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Validate and sanitize input to prevent SQL injection
        $validated = $request->validate([
            'search' => 'nullable|string|max:100',
            'class_id' => 'nullable|integer|exists:classes,id',
        ]);
        
        $query = Student::with('classRoom');
        
        if (!empty($validated['search'])) {
            $search = $validated['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%');
            });
        }
        
        if (!empty($validated['class_id'])) {
            $query->where('class_id', $validated['class_id']);
        }
        
        $students = $query->orderBy('name')->paginate(20);
        $classes = ClassRoom::orderBy('name')->get();
        
        return view('students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes = ClassRoom::orderBy('name')->get();
        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:students',
            'name' => 'required|string|max:100',
            'gender' => 'required|in:L,P',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'parent_name' => 'nullable|string|max:100',
            'parent_phone' => 'nullable|string|max:20',
            'class_id' => 'required|exists:classes,id',
            'status' => 'required|in:aktif,lulus,pindah,keluar',
        ]);
        
        Student::create($validated);
        
        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Student $student)
    {
        $student->load(['classRoom', 'academicGrades.subject', 'nonAcademicRecords', 'gaResults']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classes = ClassRoom::orderBy('name')->get();
        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:students,nis,' . $student->id,
            'name' => 'required|string|max:100',
            'gender' => 'required|in:L,P',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'parent_name' => 'nullable|string|max:100',
            'parent_phone' => 'nullable|string|max:20',
            'class_id' => 'required|exists:classes,id',
            'status' => 'required|in:aktif,lulus,pindah,keluar',
        ]);
        
        $student->update($validated);
        
        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        
        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function grades(Student $student)
    {
        $student->load(['academicGrades.subject', 'nonAcademicRecords']);
        return view('students.grades', compact('student'));
    }
}
