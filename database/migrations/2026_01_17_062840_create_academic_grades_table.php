<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->string('semester'); // "Ganjil" or "Genap"
            $table->string('academic_year'); // "2024/2025"
            $table->decimal('daily_score', 5, 2)->nullable(); // Nilai Harian
            $table->decimal('midterm_score', 5, 2)->nullable(); // UTS
            $table->decimal('final_score', 5, 2)->nullable(); // UAS
            $table->decimal('final_grade', 5, 2)->nullable(); // Rata-rata
            $table->text('notes')->nullable();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Prevent duplicate entries
            $table->unique(['student_id', 'subject_id', 'semester', 'academic_year'], 'unique_academic_grade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_grades');
    }
};