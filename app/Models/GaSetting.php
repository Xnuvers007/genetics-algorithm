<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'population_size', 'max_generations', 'crossover_rate',
        'mutation_rate', 'academic_weight', 'non_academic_weight',
        'target_threshold', 'optimization_mode', 'classification_ranges'
    ];

    protected $casts = [
        'classification_ranges' => 'array',
    ];

    public static function current()
    {
        return self::first() ?? self::create([
            'population_size' => 50,
            'max_generations' => 100,
            'crossover_rate' => 0.80,
            'mutation_rate' => 0.05,
            'academic_weight' => 0.60,
            'non_academic_weight' => 0.40,
            'target_threshold' => 80.00,
        ]);
    }
}