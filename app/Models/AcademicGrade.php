<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'subject_id', 'semester', 'academic_year',
        'daily_score', 'midterm_score', 'final_score', 
        'final_grade', 'notes', 'teacher_id'
    ];

    protected static function boot()
    {
        parent::boot();
        
        // Auto-calculate final_grade
        static::saving(function ($grade) {
            if ($grade->daily_score && $grade->midterm_score && $grade->final_score) {
                // Formula: (Daily*30% + Midterm*30% + Final*40%)
                $grade->final_grade = round(
                    ($grade->daily_score * 0.3) + 
                    ($grade->midterm_score * 0.3) + 
                    ($grade->final_score * 0.4), 
                    2
                );
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}