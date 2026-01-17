<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique(); // Nomor Induk Siswa
            $table->string('nisn')->unique()->nullable(); // Nomor Induk Siswa Nasional
            $table->string('name');
            $table->enum('gender', ['L', 'P']); // Laki-laki, Perempuan
            $table->date('birth_date');
            $table->string('birth_place');
            $table->text('address');
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Link to user account
            $table->string('photo')->nullable();
            $table->enum('status', ['aktif', 'lulus', 'pindah', 'keluar'])->default('aktif');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};