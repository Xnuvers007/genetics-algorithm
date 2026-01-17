<?php

namespace App\Imports;

use App\Models\AcademicGrade;
use App\Models\Student;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GradesImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Validation rules for each row
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|integer|exists:students,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'semester' => 'required|in:Ganjil,Genap',
            'academic_year' => 'required|string|max:20|regex:/^\d{4}\/\d{4}$/',
            'daily_score' => 'required|numeric|min:0|max:100',
            'midterm_score' => 'required|numeric|min:0|max:100',
            'final_score' => 'required|numeric|min:0|max:100',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages(): array
    {
        return [
            'student_id.exists' => 'ID Siswa tidak ditemukan pada baris :row',
            'subject_id.exists' => 'ID Mata Pelajaran tidak ditemukan pada baris :row',
            'semester.in' => 'Semester harus Ganjil atau Genap pada baris :row',
            'academic_year.regex' => 'Format tahun ajaran harus YYYY/YYYY pada baris :row',
            '*.min' => 'Nilai minimal adalah 0 pada baris :row',
            '*.max' => 'Nilai maksimal adalah 100 pada baris :row',
        ];
    }

    public function model(array $row)
    {
        return new AcademicGrade([
            'student_id' => (int) $row['student_id'],
            'subject_id' => (int) $row['subject_id'],
            'semester' => trim($row['semester']),
            'academic_year' => trim($row['academic_year']),
            'daily_score' => (float) $row['daily_score'],
            'midterm_score' => (float) $row['midterm_score'],
            'final_score' => (float) $row['final_score'],
            'teacher_id' => auth()->id()
        ]);
    }
}
