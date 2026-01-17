<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name', 'grade_level', 'academic_year', 
        'homeroom_teacher_id', 'capacity'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function homeroomTeacher()
    {
        return $this->belongsTo(User::class, 'homeroom_teacher_id');
    }

    public function getStudentCountAttribute()
    {
        return $this->students()->count();
    }
}