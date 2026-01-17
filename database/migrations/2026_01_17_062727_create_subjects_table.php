<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Matematika", "Bahasa Indonesia"
            $table->string('code')->unique(); // e.g., "MTK", "BIND"
            $table->enum('category', ['akademik', 'non_akademik'])->default('akademik');
            $table->enum('grade_level', ['7', '8', '9', 'all'])->default('all');
            $table->integer('kkm')->default(75); // Kriteria Ketuntasan Minimal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};