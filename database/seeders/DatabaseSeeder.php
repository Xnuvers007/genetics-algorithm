<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Subject;
use App\Models\AcademicGrade;
use App\Models\NonAcademicRecord;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@smpbu.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nip' => '199001012015011001'
        ]);

        // Create Teachers
        $teacher1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@smpbu.sch.id',
            'password' => Hash::make('password'),
            'role' => 'wali_kelas',
            'nip' => '199102022016021001',
            'phone' => '081234567890'
        ]);

        $teacher2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@smpbu.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => '199203032017031001',
            'phone' => '081234567891'
        ]);

        // Create Classes
        $class7A = ClassRoom::create([
            'name' => '7A',
            'grade_level' => '7',
            'academic_year' => '2024/2025',
            'homeroom_teacher_id' => $teacher1->id,
            'capacity' => 30
        ]);

        $class7B = ClassRoom::create([
            'name' => '7B',
            'grade_level' => '7',
            'academic_year' => '2024/2025',
            'homeroom_teacher_id' => $teacher2->id,
            'capacity' => 30
        ]);

        $class8A = ClassRoom::create([
            'name' => '8A',
            'grade_level' => '8',
            'academic_year' => '2024/2025',
            'capacity' => 30
        ]);

        // Create Subjects
        $subjects = [
            ['name' => 'Matematika', 'code' => 'MTK', 'category' => 'akademik', 'kkm' => 75],
            ['name' => 'Bahasa Indonesia', 'code' => 'BIND', 'category' => 'akademik', 'kkm' => 75],
            ['name' => 'Bahasa Inggris', 'code' => 'BING', 'category' => 'akademik', 'kkm' => 75],
            ['name' => 'IPA', 'code' => 'IPA', 'category' => 'akademik', 'kkm' => 75],
            ['name' => 'IPS', 'code' => 'IPS', 'category' => 'akademik', 'kkm' => 75],
            ['name' => 'Pendidikan Agama Islam', 'code' => 'PAI', 'category' => 'akademik', 'kkm' => 75],
            ['name' => 'Pendidikan Kewarganegaraan', 'code' => 'PKN', 'category' => 'akademik', 'kkm' => 75],
            ['name' => 'Seni Budaya', 'code' => 'SB', 'category' => 'akademik', 'kkm' => 75],
            ['name' => 'Pendidikan Jasmani', 'code' => 'PJOK', 'category' => 'akademik', 'kkm' => 75],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

        // Create Students with Accounts
        $studentNames = [
            ['Ahmad Rizki', 'L'],
            ['Fatimah Azzahra', 'P'],
            ['Muhammad Fauzan', 'L'],
            ['Salsabila Putri', 'P'],
            ['Dimas Prasetyo', 'L'],
            ['Nur Hasanah', 'P'],
            ['Farhan Abdullah', 'L'],
            ['Zahra Kamila', 'P'],
            ['Ilham Maulana', 'L'],
            ['Aisyah Rahma', 'P'],
            ['Rafi Akbar', 'L'],
            ['Nabila Syifa', 'P'],
            ['Yoga Pratama', 'L'],
            ['Dewi Lestari', 'P'],
            ['Arif Hidayat', 'L']
        ];

        foreach ($studentNames as $index => $nameData) {
            $nis = '2024' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            $nisn = '0000' . $nis;
            
            // Create user account for student
            $userStudent = User::create([
                'name' => $nameData[0],
                'email' => strtolower(str_replace(' ', '.', $nameData[0])) . '@student.smpbu.sch.id',
                'password' => Hash::make('password'),
                'role' => 'siswa'
            ]);

            // Assign to class (distribute evenly)
            $classId = $index < 5 ? $class7A->id : ($index < 10 ? $class7B->id : $class8A->id);

            $student = Student::create([
                'nis' => $nis,
                'nisn' => $nisn,
                'name' => $nameData[0],
                'gender' => $nameData[1],
                'birth_date' => now()->subYears(13)->subMonths(rand(0, 11)),
                'birth_place' => 'Jakarta',
                'address' => 'Jl. Contoh No. ' . ($index + 1) . ', Jakarta',
                'parent_name' => 'Orang Tua ' . $nameData[0],
                'parent_phone' => '0812' . rand(10000000, 99999999),
                'class_id' => $classId,
                'user_id' => $userStudent->id,
                'status' => 'aktif'
            ]);

            // Create Academic Grades
            $subjectsList = Subject::where('category', 'akademik')->get();
            foreach ($subjectsList as $subject) {
                $daily = rand(70, 95);
                $midterm = rand(70, 95);
                $final = rand(70, 95);

                AcademicGrade::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'semester' => 'Ganjil',
                    'academic_year' => '2024/2025',
                    'daily_score' => $daily,
                    'midterm_score' => $midterm,
                    'final_score' => $final,
                    'teacher_id' => $teacher1->id
                ]);
            }

            // Create Non-Academic Records
            $nonAcademicActivities = [
                ['category' => 'ekstrakurikuler', 'name' => 'Pramuka', 'score' => rand(75, 95)],
                ['category' => 'prestasi', 'name' => 'Juara Lomba Pidato', 'score' => 90, 'level' => 'Perak'],
                ['category' => 'sikap', 'name' => 'Kedisiplinan', 'score' => rand(80, 95)],
                ['category' => 'kehadiran', 'name' => 'Kehadiran Semester 1', 'score' => rand(85, 100)],
            ];

            foreach ($nonAcademicActivities as $activity) {
                NonAcademicRecord::create([
                    'student_id' => $student->id,
                    'category' => $activity['category'],
                    'name' => $activity['name'],
                    'semester' => 'Ganjil',
                    'academic_year' => '2024/2025',
                    'score' => $activity['score'],
                    'achievement_level' => $activity['level'] ?? null,
                    'description' => 'Catatan ' . $activity['name'],
                    'date' => now()->subDays(rand(1, 90))
                ]);
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@smpbu.sch.id / password');
        $this->command->info('Teacher: budi@smpbu.sch.id / password');
        $this->command->info('Student: ahmad.rizki@student.smpbu.sch.id / password');
    }
}