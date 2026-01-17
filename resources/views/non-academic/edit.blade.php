@extends('layouts.app')

@section('title', 'Edit Rekam Non-Akademik')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Rekam Non-Akademik</h2>
        
        <form action="{{ route('non-academic.update', $nonAcademic) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Siswa *</label>
                <select name="student_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id', $nonAcademic->student_id) == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} ({{ $student->nis }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kegiatan *</label>
                <input type="text" name="activity_name" value="{{ old('activity_name', $nonAcademic->activity_name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="Ekstrakurikuler" {{ old('category', $nonAcademic->category) == 'Ekstrakurikuler' ? 'selected' : '' }}>Ekstrakurikuler</option>
                    <option value="Prestasi" {{ old('category', $nonAcademic->category) == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                    <option value="Sikap" {{ old('category', $nonAcademic->category) == 'Sikap' ? 'selected' : '' }}>Sikap</option>
                    <option value="Kehadiran" {{ old('category', $nonAcademic->category) == 'Kehadiran' ? 'selected' : '' }}>Kehadiran</option>
                    <option value="Lainnya" {{ old('category', $nonAcademic->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Semester *</label>
                    <select name="semester" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="Ganjil" {{ old('semester', $nonAcademic->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('semester', $nonAcademic->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran *</label>
                    <input type="text" name="academic_year" value="{{ old('academic_year', $nonAcademic->academic_year) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai *</label>
                    <input type="number" name="score" value="{{ old('score', $nonAcademic->score) }}" min="0" max="100" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prestasi</label>
                    <input type="text" name="achievement" value="{{ old('achievement', $nonAcademic->achievement) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('notes', $nonAcademic->notes) }}</textarea>
            </div>
            
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('non-academic.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</a>
                <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
