<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'category', 'grade_level', 'kkm'
    ];

    public function academicGrades()
    {
        return $this->hasMany(AcademicGrade::class);
    }
}