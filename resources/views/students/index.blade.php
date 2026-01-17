@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Data Siswa</h2>
            <p class="text-gray-600 mt-1">Kelola data siswa SMP Islam Bahrul Ulum</p>
        </div>
        <a href="{{ route('students.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
            + Tambah Siswa
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('students.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIS..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
            <div class="w-48">
                <select name="class_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $student->nis }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $student->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $student->classRoom->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($student->status == 'aktif') bg-green-100 text-green-800
                                @elseif($student->status == 'lulus') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('students.show', $student) }}"
                                class="inline-flex items-center px-3 py-1.5 bg-blue hover:bg-gray-100 text-black text-sm font-medium rounded-md shadow-sm border border-gray-300"
                                style="background-color: #003cff; color: white; border-color: black; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);"
                                >
                                        Lihat
                                </a>

                                <a href="{{ route('students.edit', $student) }}"
                                class="inline-flex items-center px-3 py-1.5 bg-blue hover:bg-gray-100 text-black text-sm font-medium rounded-md shadow-sm border border-gray-300"
                                style="background-color: #fbff00; color: black; border-color: black; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);"
                                >
                                    Edit
                                </a>

                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue hover:bg-gray-100 text-black text-sm font-medium rounded-md shadow-sm border border-gray-300"
                                    style="background-color: #ff0000; color: white; border-color: black; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);"
                                    >
                                    Hapus
                                </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Belum ada data siswa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
