@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Data Kelas</h2>
            <p class="text-gray-600 mt-1">Kelola data kelas SMP Islam Bahrul Ulum</p>
        </div>
        <a href="{{ route('classes.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
            + Tambah Kelas
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($classes as $class)
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $class->name }}</h3>
                    <p class="text-gray-600">Kelas {{ $class->grade_level }} - {{ $class->academic_year }}</p>
                </div>
                <span class="px-3 py-1 text-sm bg-emerald-100 text-emerald-800 rounded-full">
                    {{ $class->students->count() }} siswa
                </span>
            </div>
            
            <div class="mb-4">
                <p class="text-sm text-gray-500">Wali Kelas</p>
                <p class="text-gray-800 font-medium">{{ $class->homeroomTeacher->name ?? 'Belum ditentukan' }}</p>
            </div>
            
            <div class="flex space-x-2">
                <a href="{{ route('classes.show', $class) }}" class="flex-1 text-center px-4 py-2 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200 transition">Lihat</a>
                <a href="{{ route('classes.edit', $class) }}" class="flex-1 text-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200 transition">Edit</a>
                <form action="{{ route('classes.destroy', $class) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus kelas ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-800 rounded-lg hover:bg-red-200 transition">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-gray-500">
            Belum ada data kelas.
        </div>
        @endforelse
    </div>
</div>
@endsection
