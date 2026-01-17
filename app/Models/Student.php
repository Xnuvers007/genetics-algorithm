<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nis', 'nisn', 'name', 'gender', 'birth_date', 'birth_place',
        'address', 'parent_name', 'parent_phone', 'class_id', 
        'user_id', 'photo', 'status'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Relationships
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function academicGrades()
    {
        return $this->hasMany(AcademicGrade::class);
    }

    public function nonAcademicRecords()
    {
        return $this->hasMany(NonAcademicRecord::class);
    }

    public function gaResults()
    {
        return $this->hasMany(GaResult::class);
    }

    // Helper: Get average academic score for a semester
    public function getAcademicAverage($semester, $academicYear)
    {
        return $this->academicGrades()
            ->where('semester', $semester)
            ->where('academic_year', $academicYear)
            ->avg('final_grade') ?? 0;
    }

    // Helper: Get average non-academic score for a semester
    public function getNonAcademicAverage($semester, $academicYear)
    {
        return $this->nonAcademicRecords()
            ->where('semester', $semester)
            ->where('academic_year', $academicYear)
            ->avg('score') ?? 0;
    }
}