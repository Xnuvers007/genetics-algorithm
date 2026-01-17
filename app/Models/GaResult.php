<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'semester', 'academic_year',
        'academic_average', 'non_academic_average', 'weighted_score',
        'classification', 'recommendation', 'generation_reached',
        'fitness_improvement', 'evolution_data', 'processed_by'
    ];

    protected $casts = [
        'evolution_data' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}