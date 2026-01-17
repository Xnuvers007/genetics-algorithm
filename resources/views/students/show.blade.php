@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $student->name }}</h2>
            <p class="text-gray-600 mt-1">NIS: {{ $student->nis }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('students.show', $student) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">Lihat</a>
            <a href="{{ route('students.edit', $student) }}" class="px-4 py-2 bg-yellow-400 text-white rounded-md hover:bg-yellow-500 transition">Edit</a>
            <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Info Card -->
        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row gap-6">
            <div class="w-full md:w-1/4 flex items-center justify-center">
                <div class="w-32 h-32 rounded-full overflow-hidden shadow-lg bg-gray-100 flex items-center justify-center">
                    @if($student->photo)
                        <img src="{{ asset('storage/' . $student->photo) }}" alt="Foto {{ $student->name }}" class="w-full h-full object-cover">
                    @else
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-gray-300">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" fill="#cbd5e1"/>
                            <path d="M4 20c0-2.21 3.58-4 8-4s8 1.79 8 4v1H4v-1z" fill="#e2e8f0"/>
                        </svg>
                    @endif
                </div>
            </div>

            <div class="w-full md:w-3/4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Informasi Siswa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama</p>
                        <p class="font-medium text-gray-800">{{ $student->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">NIS</p>
                        <p class="font-medium text-gray-800">{{ $student->nis }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kelas</p>
                        <p class="font-medium text-gray-800">{{ $student->classRoom->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <p>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($student->status == 'aktif') bg-green-100 text-green-800
                                @elseif($student->status == 'lulus') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($student->status) }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Jenis Kelamin</p>
                        <p class="font-medium text-gray-800">{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                        <p class="font-medium text-gray-800">{{ $student->birth_place ?? '-' }}, {{ $student->birth_date?->format('d M Y') ?? '-' }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="font-medium text-gray-800">{{ $student->address ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Nama Orang Tua</p>
                        <p class="font-medium text-gray-800">{{ $student->parent_name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">No. Telp Orang Tua</p>
                        <p class="font-medium text-gray-800">{{ $student->parent_phone ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Grades -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Nilai Akademik</h3>
            @if($student->academicGrades->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Semester</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($student->academicGrades as $grade)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $grade->subject->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $grade->semester }} {{ $grade->academic_year }}</td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-800">{{ $grade->score }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500">Belum ada data nilai akademik.</p>
            @endif
        </div>
    </div>

    <!-- GA Results -->
    @if($student->gaResults->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Hasil Klasifikasi GA</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Semester</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Rata-rata Akademik</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Rata-rata Non-Akademik</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Skor Akhir</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Klasifikasi</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($student->gaResults as $result)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $result->semester }} {{ $result->academic_year }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ number_format($result->academic_average, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ number_format($result->non_academic_average, 2) }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800">{{ number_format($result->weighted_score, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($result->classification == 'Sangat Baik') bg-green-100 text-green-800
                                @elseif($result->classification == 'Baik') bg-blue-100 text-blue-800
                                @elseif($result->classification == 'Cukup') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $result->classification }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('ga.result', $result->id) }}" class="text-emerald-600 hover:text-emerald-800">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
