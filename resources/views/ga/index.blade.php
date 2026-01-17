@extends('layouts.app')

@section('title', 'Algoritma Genetik')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Algoritma Genetik</h2>
            <p class="text-gray-600 mt-1">Proses klasifikasi siswa menggunakan Genetic Algorithm</p>
        </div>
        <a href="{{ route('ga.settings') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            ⚙️ Pengaturan GA
        </a>
    </div>

    <!-- Execute GA Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Jalankan Algoritma Genetik</h3>
        
        <form action="{{ route('ga.execute') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                    <select name="semester" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran</label>
                    <input type="text" name="academic_year" value="2024/2025" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-800">
                    <strong>Info:</strong> Proses ini akan menganalisis semua siswa aktif berdasarkan nilai akademik dan non-akademik, 
                    kemudian mengklasifikasikan mereka menggunakan algoritma genetik dengan parameter yang telah dikonfigurasi.
                </p>
            </div>

            <button type="submit" class="w-full px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition">
                🚀 Jalankan Algoritma Genetik
            </button>
        </form>
    </div>

    <!-- Current Settings Info -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Parameter Saat Ini</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">Ukuran Populasi</p>
                <p class="text-2xl font-bold text-gray-800">{{ $settings->population_size }}</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">Max Generasi</p>
                <p class="text-2xl font-bold text-gray-800">{{ $settings->max_generations }}</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">Bobot Akademik</p>
                <p class="text-2xl font-bold text-gray-800">{{ $settings->academic_weight * 100 }}%</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">Bobot Non-Akademik</p>
                <p class="text-2xl font-bold text-gray-800">{{ $settings->non_academic_weight * 100 }}%</p>
            </div>
        </div>
    </div>

    <!-- Recent Results -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Hasil Pemrosesan Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Akademik</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Non-Akademik</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skor Akhir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Klasifikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentResults as $result)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $result->student->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $result->semester }} {{ $result->academic_year }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ number_format($result->academic_average, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ number_format($result->non_academic_average, 2) }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ number_format($result->weighted_score, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($result->classification == 'Sangat Baik') bg-green-100 text-green-800
                                @elseif($result->classification == 'Baik') bg-blue-100 text-blue-800
                                @elseif($result->classification == 'Cukup') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $result->classification }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('ga.result', $result->id) }}" class="text-emerald-600 hover:text-emerald-800 font-medium">
                                Detail →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            Belum ada hasil pemrosesan. Jalankan algoritma genetik untuk memulai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $recentResults->links() }}
        </div>
    </div>
</div>
@endsection
