<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ga_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('population_size')->default(50);
            $table->integer('max_generations')->default(100);
            $table->decimal('crossover_rate', 3, 2)->default(0.80); // 80%
            $table->decimal('mutation_rate', 3, 2)->default(0.05); // 5%
            $table->decimal('academic_weight', 3, 2)->default(0.60); // 60%
            $table->decimal('non_academic_weight', 3, 2)->default(0.40); // 40%
            $table->decimal('target_threshold', 5, 2)->default(80.00); // Target fitness
            $table->enum('optimization_mode', ['maximize', 'classify'])->default('classify');
            $table->json('classification_ranges')->nullable(); // {"excellent": [90,100], "good": [75,89]}
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('ga_settings')->insert([
            'population_size' => 50,
            'max_generations' => 100,
            'crossover_rate' => 0.80,
            'mutation_rate' => 0.05,
            'academic_weight' => 0.60,
            'non_academic_weight' => 0.40,
            'target_threshold' => 80.00,
            'optimization_mode' => 'classify',
            'classification_ranges' => json_encode([
                'Sangat Baik' => ['min' => 90, 'max' => 100],
                'Baik' => ['min' => 75, 'max' => 89],
                'Cukup' => ['min' => 60, 'max' => 74],
                'Perlu Bimbingan' => ['min' => 0, 'max' => 59]
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('ga_settings');
    }
};