<?php

namespace App\Http\Controllers;

use App\Services\GeneticAlgorithmService;
use App\Models\GaSetting;
use App\Models\GaResult;
use Illuminate\Http\Request;

class GeneticAlgorithmController extends Controller
{
    protected $gaService;

    public function __construct(GeneticAlgorithmService $gaService)
    {
        $this->gaService = $gaService;
    }

    public function index()
    {
        $settings = GaSetting::current();
        $recentResults = GaResult::with('student')
            ->latest()
            ->paginate(20);

        return view('ga.index', compact('settings', 'recentResults'));
    }

    public function settings()
    {
        $settings = GaSetting::current();
        return view('ga.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'population_size' => 'required|integer|min:10|max:200',
            'max_generations' => 'required|integer|min:10|max:500',
            'crossover_rate' => 'required|numeric|min:0|max:1',
            'mutation_rate' => 'required|numeric|min:0|max:1',
            'academic_weight' => 'required|numeric|min:0|max:1',
            'non_academic_weight' => 'required|numeric|min:0|max:1',
            'target_threshold' => 'required|numeric|min:0|max:100',
        ]);

        // Ensure weights sum to 1
        if (($validated['academic_weight'] + $validated['non_academic_weight']) != 1) {
            return back()->with('error', 'Bobot akademik dan non-akademik harus berjumlah 1.0');
        }

        $settings = GaSetting::current();
        $settings->update($validated);

        return back()->with('success', 'Pengaturan algoritma genetik berhasil diperbarui.');
    }

    public function execute(Request $request)
    {
        $validated = $request->validate([
            'semester' => 'required|in:Ganjil,Genap',
            'academic_year' => 'required|string'
        ]);

        try {
            $result = $this->gaService->execute(
                $validated['semester'],
                $validated['academic_year']
            );

            return back()->with('success', 
                "Algoritma genetik berhasil dijalankan untuk {$result['total_students']} siswa. " .
                "Generasi: {$result['generations']}, Best Fitness: {$result['best_fitness']}"
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function viewResult($id)
    {
        $result = GaResult::with(['student', 'processor'])
            ->findOrFail($id);

        return view('ga.result-detail', compact('result'));
    }

    public function statistics(Request $request)
    {
        $semester = $request->input('semester', 'Ganjil');
        $academicYear = $request->input('academic_year', '2024/2025');

        $stats = $this->gaService->getStatistics($semester, $academicYear);

        return view('ga.statistics', compact('stats', 'semester', 'academicYear'));
    }
}
