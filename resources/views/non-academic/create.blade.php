@extends('layouts.app')

@section('title', 'Tambah Rekam Non-Akademik')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Rekam Non-Akademik</h2>
        
        <form action="{{ route('non-academic.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Siswa *</label>
                <select name="student_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    <option value="">Pilih Siswa</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} ({{ $student->nis }})
                        </option>
                    @endforeach
                </select>
                @error('student_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kegiatan *</label>
                <input type="text" name="activity_name" value="{{ old('activity_name') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                @error('activity_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Pilih Kategori</option>
                    <option value="Ekstrakurikuler" {{ old('category') == 'Ekstrakurikuler' ? 'selected' : '' }}>Ekstrakurikuler</option>
                    <option value="Prestasi" {{ old('category') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                    <option value="Sikap" {{ old('category') == 'Sikap' ? 'selected' : '' }}>Sikap</option>
                    <option value="Kehadiran" {{ old('category') == 'Kehadiran' ? 'selected' : '' }}>Kehadiran</option>
                    <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Semester *</label>
                    <select name="semester" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran *</label>
                    <input type="text" name="academic_year" value="{{ old('academic_year', '2024/2025') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai *</label>
                    <input type="number" name="score" value="{{ old('score') }}" min="0" max="100" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    @error('score')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prestasi</label>
                    <input type="text" name="achievement" value="{{ old('achievement') }}" placeholder="Juara 1, Juara 2, dll"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('notes') }}</textarea>
            </div>
            
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('non-academic.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</a>
                <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
