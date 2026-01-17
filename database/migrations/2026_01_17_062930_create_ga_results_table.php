<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ga_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('semester');
            $table->string('academic_year');
            $table->decimal('academic_average', 5, 2);
            $table->decimal('non_academic_average', 5, 2);
            $table->decimal('weighted_score', 5, 2); // Final fitness score
            $table->string('classification'); // "Sangat Baik", "Baik", etc.
            $table->text('recommendation')->nullable();
            $table->integer('generation_reached')->default(0);
            $table->decimal('fitness_improvement', 5, 2)->default(0);
            $table->json('evolution_data')->nullable(); // Track fitness per generation
            $table->foreignId('processed_by')->constrained('users');
            $table->timestamps();
            
            $table->unique(['student_id', 'semester', 'academic_year'], 'unique_ga_result');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ga_results');
    }
};