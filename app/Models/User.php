<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nip', 'phone'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function homeroomClasses()
    {
        return $this->hasMany(ClassRoom::class, 'homeroom_teacher_id');
    }

    public function academicGrades()
    {
        return $this->hasMany(AcademicGrade::class, 'teacher_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTeacher()
    {
        return $this->role === 'guru';
    }

    public function isHomeroomTeacher()
    {
        return $this->role === 'wali_kelas';
    }

    public function isStudent()
    {
        return $this->role === 'siswa';
    }
}