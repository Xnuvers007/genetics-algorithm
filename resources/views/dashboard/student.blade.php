@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,rgba(255,255,255,0.6))]"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border-2 border-white/30">
                    <span class="text-4xl font-bold">{{ substr($student->name, 0, 1) }}</span>
                </div>
                <div class="text-gray-600 mt-1">
                    <h2 class="text-3xl font-bold">Halo, {{ explode(' ', $student->name)[0] }}! 👋</h2>
                    <p class="text-emerald-100 mt-1">Selamat belajar dan terus tingkatkan prestasimu</p>
                    <div class="flex items-center gap-3 mt-3">
                        <span class="px-3 py-1 bg-white/20 rounded-full text-sm backdrop-blur-sm">
                            📚 NIS: {{ $student->nis }}
                        </span>
                        <span class="px-3 py-1 bg-white/20 rounded-full text-sm backdrop-blur-sm">
                            🏫 Kelas {{ $student->classRoom->name ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
            @if($ga_result)
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                <p class="text-emerald-100 text-sm text-black">Klasifikasi Saat Ini</p>
                <p class="text-3xl font-bold mt-1 text-black">{{ $ga_result->classification }}</p>
                <p class="text-emerald-100 text-sm mt-1 text-black">Skor: {{ number_format($ga_result->weighted_score, 1) }}/100</p>
            </div>
            @endif
            <br />
        </div>
        <div class="absolute right-8 bottom-0 opacity-10">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
        </div>
    </div>

    @if($ga_result)
    <!-- Score Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Rata-rata Akademik</p>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($ga_result->academic_average, 1) }}</p>
            <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ min($ga_result->academic_average, 100) }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Non-Akademik</p>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($ga_result->non_academic_average, 1) }}</p>
            <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                <div class="bg-purple-500 h-2 rounded-full" style="width: {{ min($ga_result->non_academic_average, 100) }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Skor Akhir</p>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($ga_result->weighted_score, 1) }}</p>
            <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ min($ga_result->weighted_score, 100) }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Klasifikasi</p>
            </div>
            <span class="inline-flex items-center px-4 py-2 text-lg font-bold rounded-xl
                @if($ga_result->classification == 'Sangat Baik') bg-green-100 text-green-700
                @elseif($ga_result->classification == 'Baik') bg-blue-100 text-blue-700
                @elseif($ga_result->classification == 'Cukup') bg-amber-100 text-amber-700
                @else bg-red-100 text-red-700
                @endif">
                {{ $ga_result->classification }}
            </span>
        </div>
    </div>

    @if($ga_result->recommendation)
    <!-- Recommendation -->
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl border border-amber-200 p-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
            </div>
            <div>
                <h4 class="text-lg font-bold text-amber-800">💡 Rekomendasi untuk Kamu</h4>
                <p class="text-amber-700 mt-2">{{ $ga_result->recommendation }}</p>
            </div>
        </div>
    </div>
    @endif
    @endif

    <!-- Academic Grades -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Nilai Akademik</h3>
                    <p class="text-sm text-gray-500">Semester Ganjil 2024/2025</p>
                </div>
            </div>
            <a href="{{ route('reports.my') }}" class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download Raport
            </a>
        </div>
        @if($academic_grades->count() > 0)
        <div class="overflow-x-auto -mx-2 px-2">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b-2 border-gray-200 bg-gray-50">
                        <th class="py-3 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="py-3 px-2 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Harian</th>
                        <th class="py-3 px-2 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">UTS</th>
                        <th class="py-3 px-2 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">UAS</th>
                        <th class="py-3 px-2 text-center text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Rata<span class="hidden sm:inline">-rata</span></th>
                        <th class="py-3 px-2 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($academic_grades as $grade)
                    @php
                        $avg = ($grade->daily_score + $grade->midterm_score + $grade->final_score) / 3;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-xs font-bold">{{ substr($grade->subject->name ?? '-', 0, 2) }}</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $grade->subject->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <span class="text-sm font-bold {{ $grade->daily_score >= 75 ? 'text-green-700' : ($grade->daily_score >= 60 ? 'text-amber-700' : 'text-red-700') }}">
                                {{ $grade->daily_score }}
                            </span>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <span class="text-sm font-bold {{ $grade->midterm_score >= 75 ? 'text-green-700' : ($grade->midterm_score >= 60 ? 'text-amber-700' : 'text-red-700') }}">
                                {{ $grade->midterm_score }}
                            </span>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <span class="text-sm font-bold {{ $grade->final_score >= 75 ? 'text-green-700' : ($grade->final_score >= 60 ? 'text-amber-700' : 'text-red-700') }}">
                                {{ $grade->final_score }}
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
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <p class="text-gray-500 font-medium">Belum ada data nilai akademik</p>
            <p class="text-gray-400 text-sm mt-1">Nilai akan muncul setelah guru menginput</p>
        </div>
        @endif
    </div>

    <!-- Non-Academic Records -->
    @if($non_academic_records->count() > 0)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Kegiatan Non-Akademik</h3>
                <p class="text-sm text-gray-500">Ekstrakurikuler, prestasi, dan kegiatan lainnya</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($non_academic_records as $record)
            <div class="group p-5 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-100 hover:border-purple-200 hover:shadow-md transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="inline-flex items-center px-2 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full mb-2">
                            {{ $record->category }}
                        </span>
                        <h4 class="font-semibold text-gray-800">{{ $record->activity_name }}</h4>
                        @if($record->achievement)
                        <p class="text-sm text-gray-500 mt-1">🏆 {{ $record->achievement }}</p>
                        @endif
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <span class="text-black font-bold">{{ $record->score }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
