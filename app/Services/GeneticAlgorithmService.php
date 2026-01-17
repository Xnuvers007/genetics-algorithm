<?php

namespace App\Services;

use App\Models\Student;
use App\Models\GaSetting;
use App\Models\GaResult;
use Illuminate\Support\Facades\Auth;

class GeneticAlgorithmService
{
    protected $settings;
    protected $population = [];
    protected $bestFitness = 0;
    protected $evolutionHistory = [];

    public function __construct()
    {
        $this->settings = GaSetting::current();
    }

    /**
     * Main execution method
     * Processes all students for a given semester
     */
    public function execute($semester, $academicYear)
    {
        $students = Student::where('status', 'aktif')
            ->with(['academicGrades', 'nonAcademicRecords'])
            ->get();

        if ($students->isEmpty()) {
            throw new \Exception('No active students found.');
        }

        // Initialize population with student data
        $this->initializePopulation($students, $semester, $academicYear);

        // Run genetic algorithm
        for ($generation = 0; $generation < $this->settings->max_generations; $generation++) {
            // Calculate fitness for all individuals
            $this->calculateFitness();

            // Track evolution
            $this->evolutionHistory[$generation] = [
                'avg_fitness' => $this->getAverageFitness(),
                'best_fitness' => $this->bestFitness,
                'generation' => $generation + 1
            ];

            // Check convergence (optional early stopping)
            if ($this->hasConverged($generation)) {
                break;
            }

            // Selection
            $selectedParents = $this->selection();

            // Crossover
            $offspring = $this->crossover($selectedParents);

            // Mutation
            $this->mutation($offspring);

            // Replace population
            $this->population = $offspring;
        }

        // Save results to database
        $this->saveResults($semester, $academicYear);

        return [
            'total_students' => count($this->population),
            'generations' => count($this->evolutionHistory),
            'final_avg_fitness' => end($this->evolutionHistory)['avg_fitness'],
            'best_fitness' => $this->bestFitness,
            'evolution_history' => $this->evolutionHistory
        ];
    }

    /**
     * Initialize population with student data
     */
    protected function initializePopulation($students, $semester, $academicYear)
    {
        foreach ($students as $student) {
            $academicAvg = $student->getAcademicAverage($semester, $academicYear);
            $nonAcademicAvg = $student->getNonAcademicAverage($semester, $academicYear);

            // Create individual (chromosome)
            $individual = [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'genes' => [
                    'academic_score' => $academicAvg,
                    'non_academic_score' => $nonAcademicAvg,
                ],
                'fitness' => 0,
                'weighted_score' => 0
            ];

            $this->population[] = $individual;
        }
    }

    /**
     * Calculate fitness for each individual
     * Fitness = (Academic * Weight_A) + (Non-Academic * Weight_NA)
     */
    protected function calculateFitness()
    {
        foreach ($this->population as &$individual) {
            $weightedScore = 
                ($individual['genes']['academic_score'] * $this->settings->academic_weight) +
                ($individual['genes']['non_academic_score'] * $this->settings->non_academic_weight);

            $individual['weighted_score'] = round($weightedScore, 2);

            // Fitness function: How close to target threshold
            // Higher is better
            $individual['fitness'] = $weightedScore;

            // Track best fitness
            if ($individual['fitness'] > $this->bestFitness) {
                $this->bestFitness = $individual['fitness'];
            }
        }
    }

    /**
     * Selection: Roulette Wheel Selection
     * Individuals with higher fitness have higher probability
     */
    protected function selection()
    {
        $totalFitness = array_sum(array_column($this->population, 'fitness'));
        $selected = [];

        for ($i = 0; $i < count($this->population); $i++) {
            $randomPoint = mt_rand(0, (int)($totalFitness * 100)) / 100;
            $currentSum = 0;

            foreach ($this->population as $individual) {
                $currentSum += $individual['fitness'];
                if ($currentSum >= $randomPoint) {
                    $selected[] = $individual;
                    break;
                }
            }
        }

        return $selected;
    }

    /**
     * Crossover: Single Point Crossover
     * Exchange genes between parent pairs
     */
    protected function crossover($parents)
    {
        $offspring = [];
        $parentCount = count($parents);

        for ($i = 0; $i < $parentCount; $i += 2) {
            $parent1 = $parents[$i];
            $parent2 = $parents[min($i + 1, $parentCount - 1)];

            if (mt_rand(0, 100) / 100 < $this->settings->crossover_rate) {
                // Perform crossover (swap academic/non-academic emphasis)
                $child1 = $parent1;
                $child2 = $parent2;

                // Simulate trait mixing (for demonstration)
                $child1['genes']['academic_score'] = 
                    ($parent1['genes']['academic_score'] + $parent2['genes']['academic_score']) / 2;
                $child2['genes']['non_academic_score'] = 
                    ($parent1['genes']['non_academic_score'] + $parent2['genes']['non_academic_score']) / 2;

                $offspring[] = $child1;
                $offspring[] = $child2;
            } else {
                // No crossover, copy parents
                $offspring[] = $parent1;
                $offspring[] = $parent2;
            }
        }

        return $offspring;
    }

    /**
     * Mutation: Random gene modification
     * Small probability to adjust scores
     */
    protected function mutation(&$offspring)
    {
        foreach ($offspring as &$individual) {
            if (mt_rand(0, 100) / 100 < $this->settings->mutation_rate) {
                // Random mutation: ±5% adjustment
                $mutationFactor = (mt_rand(-5, 5) / 100);
                
                if (mt_rand(0, 1) == 0) {
                    $individual['genes']['academic_score'] *= (1 + $mutationFactor);
                    $individual['genes']['academic_score'] = max(0, min(100, $individual['genes']['academic_score']));
                } else {
                    $individual['genes']['non_academic_score'] *= (1 + $mutationFactor);
                    $individual['genes']['non_academic_score'] = max(0, min(100, $individual['genes']['non_academic_score']));
                }
            }
        }
    }

    /**
     * Check if algorithm has converged
     */
    protected function hasConverged($generation)
    {
        if ($generation < 10) return false;

        // Check if fitness hasn't improved in last 10 generations
        $recent = array_slice($this->evolutionHistory, -10, 10);
        $fitnessValues = array_column($recent, 'best_fitness');
        
        return count(array_unique($fitnessValues)) === 1;
    }

    /**
     * Get average fitness of current population
     */
    protected function getAverageFitness()
    {
            $totalFitness = array_sum(array_column($this->population, 'fitness'));
    return round($totalFitness / count($this->population), 2);
}

/**
 * Classify student based on weighted score
 */
protected function classify($weightedScore)
{
    $ranges = $this->settings->classification_ranges;

    foreach ($ranges as $category => $range) {
        if ($weightedScore >= $range['min'] && $weightedScore <= $range['max']) {
            return $category;
        }
    }

    return 'Tidak Terkategori';
}

/**
 * Generate recommendation based on classification
 */
protected function generateRecommendation($classification, $academicAvg, $nonAcademicAvg)
{
    $recommendations = [
        'Sangat Baik' => 'Pertahankan prestasi dengan program pengayaan dan kesempatan menjadi tutor sebaya.',
        'Baik' => 'Tingkatkan konsistensi belajar dan partisipasi aktif dalam kegiatan sekolah.',
        'Cukup' => 'Perlukan bimbingan tambahan pada mata pelajaran yang lemah dan motivasi ekstra.',
        'Perlu Bimbingan' => 'Memerlukan perhatian khusus, program remedial intensif, dan pendampingan orang tua.',
    ];

    $baseRec = $recommendations[$classification] ?? 'Lanjutkan usaha dan konsultasi dengan wali kelas.';

    // Add specific recommendations
    if ($academicAvg < 70) {
        $baseRec .= ' Fokus pada peningkatan nilai akademik melalui les tambahan.';
    }
    if ($nonAcademicAvg < 70) {
        $baseRec .= ' Dorong partisipasi dalam kegiatan ekstrakurikuler untuk pengembangan non-akademik.';
    }

    return $baseRec;
}

/**
 * Save GA results to database
 */
protected function saveResults($semester, $academicYear)
{
    foreach ($this->population as $individual) {
        $classification = $this->classify($individual['weighted_score']);
        $recommendation = $this->generateRecommendation(
            $classification,
            $individual['genes']['academic_score'],
            $individual['genes']['non_academic_score']
        );

        GaResult::updateOrCreate(
            [
                'student_id' => $individual['student_id'],
                'semester' => $semester,
                'academic_year' => $academicYear,
            ],
            [
                'academic_average' => round($individual['genes']['academic_score'], 2),
                'non_academic_average' => round($individual['genes']['non_academic_score'], 2),
                'weighted_score' => $individual['weighted_score'],
                'classification' => $classification,
                'recommendation' => $recommendation,
                'generation_reached' => count($this->evolutionHistory),
                'fitness_improvement' => round($this->bestFitness - ($this->evolutionHistory[0]['best_fitness'] ?? 0), 2),
                'evolution_data' => $this->evolutionHistory,
                'processed_by' => Auth::id(),
            ]
        );
    }
}

/**
 * Get results for a specific student
 */
public function getStudentResult($studentId, $semester, $academicYear)
{
    return GaResult::where('student_id', $studentId)
        ->where('semester', $semester)
        ->where('academic_year', $academicYear)
        ->first();
}

/**
 * Get statistics for all students
 */
public function getStatistics($semester, $academicYear)
{
    $results = GaResult::where('semester', $semester)
        ->where('academic_year', $academicYear)
        ->get();

    return [
        'total' => $results->count(),
        'avg_academic' => $results->avg('academic_average'),
        'avg_non_academic' => $results->avg('non_academic_average'),
        'avg_weighted' => $results->avg('weighted_score'),
        'classification_breakdown' => $results->groupBy('classification')
            ->map->count()
            ->toArray()
    ];
}
}