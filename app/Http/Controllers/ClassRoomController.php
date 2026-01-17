<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::with(['homeroomTeacher', 'students'])
            ->orderBy('grade_level')
            ->orderBy('name')
            ->get();
        
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = User::whereIn('role', ['guru', 'wali_kelas'])->orderBy('name')->get();
        return view('classes.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'grade_level' => 'required|integer|between:7,9',
            'academic_year' => 'required|string|max:20',
            'homeroom_teacher_id' => 'nullable|exists:users,id',
        ]);
        
        ClassRoom::create($validated);
        
        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(ClassRoom $class)
    {
        $class->load(['homeroomTeacher', 'students']);
        return view('classes.show', compact('class'));
    }

    public function edit(ClassRoom $class)
    {
        $teachers = User::whereIn('role', ['guru', 'wali_kelas'])->orderBy('name')->get();
        return view('classes.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'grade_level' => 'required|integer|between:7,9',
            'academic_year' => 'required|string|max:20',
            'homeroom_teacher_id' => 'nullable|exists:users,id',
        ]);
        
        $class->update($validated);
        
        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(ClassRoom $class)
    {
        if ($class->students()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kelas yang masih memiliki siswa.');
        }
        
        $class->delete();
        
        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
