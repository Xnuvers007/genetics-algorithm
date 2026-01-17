@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $class->name }}</h2>
            <p class="text-gray-600 mt-1">Kelas {{ $class->grade }} - {{ $class->academic_year }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('classes.edit', $class) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">Edit</a>
            <a href="{{ route('classes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Kelas</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm text-gray-500">Wali Kelas</dt>
                    <dd class="text-gray-800 font-medium">{{ $class->homeroomTeacher->name ?? 'Belum ditentukan' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Jumlah Siswa</dt>
                    <dd class="text-gray-800 font-medium">{{ $class->students->count() }} siswa</dd>
                </div>
            </dl>
        </div>

        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Siswa</h3>
            @if($class->students->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">NIS</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">JK</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($class->students as $index => $student)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $student->nis }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $student->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $student->gender }}</td>
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('students.show', $student) }}" class="text-blue-600 hover:text-blue-800">Lihat</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500">Belum ada siswa di kelas ini.</p>
            @endif
        </div>
    </div>
</div>
@endsection
