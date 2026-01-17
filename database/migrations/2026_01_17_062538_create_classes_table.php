<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "7A", "8B"
            $table->enum('grade_level', ['7', '8', '9']); // Kelas 7, 8, 9
            $table->string('academic_year'); // e.g., "2024/2025"
            $table->foreignId('homeroom_teacher_id')->nullable()->constrained('users')->onDelete('set null'); // Wali Kelas
            $table->integer('capacity')->default(30);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};