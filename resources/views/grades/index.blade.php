@extends('layouts.app')

@section('title', 'Input Nilai')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Nilai Akademik</h2>
            <p class="text-gray-600 mt-1">Kelola nilai akademik siswa</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('grades.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                + Input Nilai
            </a>
            <a href="{{ route('grades.batch') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                📋 Input Batch
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('grades.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="w-40">
                <select name="semester" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semester</option>
                    <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>
            <div class="w-40">
                <input type="text" name="academic_year" value="{{ request('academic_year') }}" placeholder="Tahun Ajaran"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <button type="submit" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                Filter
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">UTS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">UAS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rata-rata</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($grades as $grade)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $grade->student->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $grade->subject->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $grade->semester }} {{ $grade->academic_year }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $grade->daily_score }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $grade->midterm_score }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $grade->final_score }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                            {{ number_format(($grade->daily_score + $grade->midterm_score + $grade->final_score) / 3, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('grades.edit', $grade) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                            <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus nilai ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            Belum ada data nilai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $grades->links() }}
        </div>
    </div>
</div>
@endsection
