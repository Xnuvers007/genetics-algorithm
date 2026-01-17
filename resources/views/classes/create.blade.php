@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kelas Baru</h2>
        
        <form action="{{ route('classes.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kelas *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: VII-A" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat *</label>
                <select name="grade_level" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Pilih Tingkat</option>
                    <option value="7" {{ old('grade_level') == 7 ? 'selected' : '' }}>Kelas 7</option>
                    <option value="8" {{ old('grade_level') == 8 ? 'selected' : '' }}>Kelas 8</option>
                    <option value="9" {{ old('grade_level') == 9 ? 'selected' : '' }}>Kelas 9</option>
                </select>
                @error('grade_level')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran *</label>
                <input type="text" name="academic_year" value="{{ old('academic_year', '2024/2025') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                @error('academic_year')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Wali Kelas</label>
                <select name="homeroom_teacher_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Pilih Wali Kelas</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('homeroom_teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('classes.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</a>
                <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
