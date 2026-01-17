@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-8">
    <!-- Page Header with Gradient -->
    <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700 rounded-2xl p-8 text-white shadow-xl">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,rgba(255,255,255,0.6))]"></div>
        <div class="relative z-10 text-gray-600 mt-1">
            <h2 class="text-3xl font-bold">Selamat Datang, Admin! 👋</h2>
            <p class="text-emerald-100 mt-2">Pantau dan kelola sistem monitoring SMP Islam Bahrul Ulum</p>
            <div class="flex items-center gap-4 mt-4">
                <span class="px-4 py-2 bg-white/20 rounded-full text-sm backdrop-blur-sm">
                    📅 {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </span>
                <span class="px-4 py-2 bg-white/20 rounded-full text-sm backdrop-blur-sm">
                    🕐 Semester Ganjil 2024/2025
                </span>
            </div>
        </div>
        <div class="absolute right-8 top-1/2 -translate-y-1/2 opacity-20">
            <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Siswa -->
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-blue-200 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Siswa Aktif</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $total_students }}</p>
                    <p class="text-blue-600 text-sm mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Siswa aktif
                    </p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Kelas -->
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-green-200 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Kelas</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $total_classes }}</p>
                    <p class="text-green-600 text-sm mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                        </svg>
                        Kelas aktif
                    </p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-200 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Guru -->
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-purple-200 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Guru</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $total_teachers }}</p>
                    <p class="text-purple-600 text-sm mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"></path>
                        </svg>
                        Tenaga pengajar
                    </p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-200 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Hasil GA -->
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-amber-200 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Hasil GA Terproses</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $recent_results->count() }}</p>
                    <p class="text-amber-600 text-sm mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        Klasifikasi siswa
                    </p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('students.create') }}" class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:border-emerald-200 hover:shadow-lg transition-all duration-300">
            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-500 transition-colors">
                <svg class="w-5 h-5 text-emerald-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Tambah Siswa</span>
        </a>
        <a href="{{ route('grades.create') }}" class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:border-blue-200 hover:shadow-lg transition-all duration-300">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors">
                <svg class="w-5 h-5 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Input Nilai</span>
        </a>
        <a href="{{ route('ga.index') }}" class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:border-purple-200 hover:shadow-lg transition-all duration-300">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-500 transition-colors">
                <svg class="w-5 h-5 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Jalankan GA</span>
        </a>
        <a href="{{ route('reports.index') }}" class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:border-rose-200 hover:shadow-lg transition-all duration-300">
            <div class="w-10 h-10 bg-rose-100 rounded-lg flex items-center justify-center group-hover:bg-rose-500 transition-colors">
                <svg class="w-5 h-5 text-rose-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Cetak Laporan</span>
        </a>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Classification Distribution -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Distribusi Klasifikasi</h3>
                    <p class="text-sm text-gray-500">Pembagian hasil klasifikasi siswa</p>
                </div>
                <div class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-medium rounded-full">
                    Semester Ini
                </div>
            </div>
            <div class="h-64">
                <canvas id="classificationChart"></canvas>
            </div>
        </div>

        <!-- Recent Results Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Hasil GA Terbaru</h3>
                    <p class="text-sm text-gray-500">10 hasil klasifikasi terakhir</p>
                </div>
                <a href="{{ route('ga.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 bg-gray-50">
                            <th class="py-3 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Siswa</th>
                            <th class="py-3 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Skor</th>
                            <th class="py-3 px-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Klasifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($recent_results as $result)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                        <span class="text-sm font-bold text-emerald-700">{{ substr($result->student->name ?? '-', 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $result->student->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-sm font-bold text-gray-800">{{ number_format($result->weighted_score, 1) }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full border
                                    @if($result->classification == 'Sangat Baik') bg-green-100 text-green-800 border-green-200
                                    @elseif($result->classification == 'Baik') bg-blue-100 text-blue-800 border-blue-200
                                    @elseif($result->classification == 'Cukup') bg-amber-100 text-amber-800 border-amber-200
                                    @else bg-red-100 text-red-800 border-red-200
                                    @endif">
                                    {{ $result->classification }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Belum ada hasil klasifikasi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Classification Distribution Chart
const ctx = document.getElementById('classificationChart');
if (ctx) {
    const classificationData = @json($classification_stats);
    
    const colors = {
        'Sangat Baik': { bg: 'rgba(16, 185, 129, 0.8)', border: 'rgb(16, 185, 129)' },
        'Baik': { bg: 'rgba(59, 130, 246, 0.8)', border: 'rgb(59, 130, 246)' },
        'Cukup': { bg: 'rgba(245, 158, 11, 0.8)', border: 'rgb(245, 158, 11)' },
        'Kurang': { bg: 'rgba(239, 68, 68, 0.8)', border: 'rgb(239, 68, 68)' }
    };

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: classificationData.map(item => item.classification),
            datasets: [{
                data: classificationData.map(item => item.count),
                backgroundColor: classificationData.map(item => colors[item.classification]?.bg || 'rgba(156, 163, 175, 0.8)'),
                borderColor: classificationData.map(item => colors[item.classification]?.border || 'rgb(156, 163, 175)'),
                borderWidth: 2,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { size: 12, weight: '500' }
                    }
                }
            }
        }
    });
}
</script>
@endpush
@endsection
