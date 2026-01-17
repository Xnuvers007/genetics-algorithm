<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('non_academic_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->enum('category', [
                'ekstrakurikuler', 
                'prestasi', 
                'sikap', 
                'kehadiran',
                'organisasi'
            ]);
            $table->string('name'); // e.g., "Pramuka", "Juara Lomba Matematika"
            $table->string('semester');
            $table->string('academic_year');
            $table->decimal('score', 5, 2)->default(0); // Normalized score (0-100)
            $table->string('achievement_level')->nullable(); // "Emas", "Perak", etc.
            $table->text('description')->nullable();
            $table->string('certificate_path')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('non_academic_records');
    }
};