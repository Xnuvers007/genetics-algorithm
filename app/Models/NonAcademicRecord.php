<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonAcademicRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'category', 'name', 'semester', 'academic_year',
        'score', 'achievement_level', 'description', 
        'certificate_path', 'date'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}