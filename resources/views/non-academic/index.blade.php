@extends('layouts.app')

@section('title', 'Non-Akademik')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Rekam Non-Akademik</h2>
            <p class="text-gray-600 mt-1">Kelola data ekstrakurikuler, prestasi, dan kegiatan non-akademik</p>
        </div>
        <a href="{{ route('non-academic.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
            + Tambah Rekam
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('non-academic.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="w-40">
                <select name="semester" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semester</option>
                    <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>
            <div class="w-48">
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Kategori</option>
                    <option value="Ekstrakurikuler" {{ request('category') == 'Ekstrakurikuler' ? 'selected' : '' }}>Ekstrakurikuler</option>
                    <option value="Prestasi" {{ request('category') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                    <option value="Sikap" {{ request('category') == 'Sikap' ? 'selected' : '' }}>Sikap</option>
                    <option value="Kehadiran" {{ request('category') == 'Kehadiran' ? 'selected' : '' }}>Kehadiran</option>
                    <option value="Lainnya" {{ request('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kegiatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prestasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($records as $record)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $record->student->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $record->activity_name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                {{ $record->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $record->semester }} {{ $record->academic_year }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $record->score }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $record->achievement ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('non-academic.edit', $record) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                            <form action="{{ route('non-academic.destroy', $record) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            Belum ada data rekam non-akademik.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $records->links() }}
        </div>
    </div>
</div>
@endsection
