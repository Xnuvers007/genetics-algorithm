@extends('layouts.app')

@section('title', 'Raport Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 rounded-2xl p-6 text-black shadow-xl text-gray-600 mt-1">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">📄 Raport Saya</h1>
                <p class="text-emerald-100 mt-1">{{ $student->name }} - {{ $student->classRoom->name ?? '-' }}</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-white/20 rounded-full text-sm">
                    Semester {{ $semester }}
                </span>
                <span class="px-3 py-1 bg-white/20 rounded-full text-sm">
                    {{ $academicYear }}
                </span>
            </div>
        </div>
    </div>

    <!-- Filter Semester -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('reports.my') }}" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <select name="semester" class="rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="Ganjil" {{ $semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ $semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                <select name="academic_year" class="rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="2024/2025" {{ $academicYear == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                    <option value="2023/2024" {{ $academicYear == '2023/2024' ? 'selected' : '' }}>2023/2024</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                Tampilkan
            </button>
        </form>
    </div>

    <!-- Student Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Informasi Siswa
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Nama Lengkap</span>
                    <span class="font-medium text-gray-900">{{ $student->name }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">NIS</span>
                    <span class="font-medium text-gray-900">{{ $student->nis }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">NISN</span>
                    <span class="font-medium text-gray-900">{{ $student->nisn ?? '-' }}</span>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Kelas</span>
                    <span class="font-medium text-gray-900">{{ $student->classRoom->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Jenis Kelamin</span>
                    <span class="font-medium text-gray-900">{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Status</span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $student->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($student->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Classification Result -->
    @if($gaResult)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            Hasil Klasifikasi AI
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-white rounded-xl border border-purple-100">
                <p class="text-sm text-gray-600 mb-1">Klasifikasi</p>
                <p class="text-2xl font-bold 
                    @if($gaResult->classification == 'Sangat Baik') text-green-600
                    @elseif($gaResult->classification == 'Baik') text-blue-600
                    @elseif($gaResult->classification == 'Cukup') text-amber-600
                    @else text-red-600
                    @endif">
                    {{ $gaResult->classification }}
                </p>
            </div>
            <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-100">
                <p class="text-sm text-gray-600 mb-1">Skor Tertimbang</p>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($gaResult->weighted_score, 1) }}</p>
            </div>
            <div class="text-center p-4 bg-gradient-to-br from-emerald-50 to-white rounded-xl border border-emerald-100">
                <p class="text-sm text-gray-600 mb-1">Generasi GA</p>
                <p class="text-2xl font-bold text-emerald-600">{{ $gaResult->generation }}</p>
            </div>
        </div>
        @if($gaResult->recommendation)
        <div class="mt-4 p-4 bg-amber-50 rounded-xl border border-amber-200">
            <p class="text-sm font-medium text-amber-800 mb-1">💡 Rekomendasi:</p>
            <p class="text-amber-700">{{ $gaResult->recommendation }}</p>
        </div>
        @endif
    </div>
    @endif

    <!-- Academic Grades -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Nilai Akademik
        </h3>
        @if($student->academicGrades->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b-2 border-gray-200 bg-gray-50">
                        <th class="py-3 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="py-3 px-2 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Harian</th>
                        <th class="py-3 px-2 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">UTS</th>
                        <th class="py-3 px-2 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">UAS</th>
                        <th class="py-3 px-2 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Rata-rata</th>
                        <th class="py-3 px-2 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @php $totalAvg = 0; $count = 0; @endphp
                    @foreach($student->academicGrades as $grade)
                    @php
                        $avg = ($grade->daily_score + $grade->midterm_score + $grade->final_score) / 3;
                        $totalAvg += $avg;
                        $count++;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">
                            <span class="text-sm font-medium text-gray-900">{{ $grade->subject->name ?? '-' }}</span>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <span class="text-sm font-bold {{ $grade->daily_score >= 75 ? 'text-green-700' : ($grade->daily_score >= 60 ? 'text-amber-700' : 'text-red-700') }}">
                                {{ number_format($grade->daily_score, 0) }}
                            </span>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <span class="text-sm font-bold {{ $grade->midterm_score >= 75 ? 'text-green-700' : ($grade->midterm_score >= 60 ? 'text-amber-700' : 'text-red-700') }}">
                                {{ number_format($grade->midterm_score, 0) }}
                            </span>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <span class="text-sm font-bold {{ $grade->final_score >= 75 ? 'text-green-700' : ($grade->final_score >= 60 ? 'text-amber-700' : 'text-red-700') }}">
                                {{ number_format($grade->final_score, 0) }}
                            </span>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <span class="inline-flex items-center justify-center min-w-[3rem] px-2 h-8 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg text-sm font-bold text-gray-900 shadow-sm">
                                {{ number_format($avg, 0) }}
                            </span>
                        </td>
                        <td class="py-3 px-2 text-center">
                            @if($avg >= 75)
                                <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full border border-green-200">
                                    ✓ Tuntas
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full border border-red-200">
                                    ✗ Belum
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @if($count > 0)
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="py-3 px-4 text-right font-bold text-gray-800">Rata-rata Keseluruhan:</td>
                        <td class="py-3 px-2 text-center">
                            <span class="inline-flex items-center justify-center min-w-[3rem] px-2 h-8 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-lg text-sm font-bold text-emerald-800 shadow-sm">
                                {{ number_format($totalAvg / $count, 1) }}
                            </span>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <p>Belum ada data nilai akademik untuk semester ini.</p>
        </div>
        @endif
    </div>

    <!-- Non-Academic Records -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
            </svg>
            Kegiatan Non-Akademik
        </h3>
        @if($student->nonAcademicRecords->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($student->nonAcademicRecords as $record)
            <div class="p-4 rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0
                        @if($record->type == 'Ekskul') bg-blue-100 text-blue-600
                        @elseif($record->type == 'Prestasi') bg-amber-100 text-amber-600
                        @else bg-purple-100 text-purple-600
                        @endif">
                        @if($record->type == 'Ekskul')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        @elseif($record->type == 'Prestasi')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900">{{ $record->activity_name }}</h4>
                        <p class="text-sm text-gray-600">{{ $record->type }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-xs px-2 py-1 bg-gray-100 rounded-full text-gray-600">
                                Skor: <strong>{{ $record->score }}</strong>
                            </span>
                        </div>
                        @if($record->notes)
                        <p class="text-sm text-gray-500 mt-2">{{ $record->notes }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
            </svg>
            <p>Belum ada data kegiatan non-akademik untuk semester ini.</p>
        </div>
        @endif
    </div>

    <!-- Download Button -->
    <div class="flex justify-center">
        <a href="{{ route('reports.my.download', ['semester' => $semester, 'academic_year' => $academicYear]) }}" 
           class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-semibold text-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg hover:shadow-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Download Raport PDF
        </a>
    </div>
</div>
@endsection
