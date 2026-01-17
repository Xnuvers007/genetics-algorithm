@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">Laporan</h2>
        <p class="text-gray-600 mt-1">Cetak laporan raport siswa dan kelas</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Student Report -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📄 Laporan Siswa</h3>
            <form action="" method="GET" id="studentReportForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Siswa</label>
                    <select name="student_id" id="student_select" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Siswa</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->classRoom->name ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                        <select name="semester" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran</label>
                        <input type="text" name="academic_year" value="2024/2025" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
                
                <button type="submit" class="w-full px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition">
                    📥 Download Raport Siswa (PDF)
                </button>
            </form>
        </div>

        <!-- Class Report -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📋 Laporan Kelas</h3>
            <form action="" method="GET" id="classReportForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kelas</label>
                    <select name="class_id" id="class_select" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->academic_year }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                        <select name="semester" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran</label>
                        <input type="text" name="academic_year" value="2024/2025" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
                
                <button type="submit" class="w-full px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition">
                    📥 Download Laporan Kelas (PDF)
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('studentReportForm').addEventListener('submit', function(e) {
    const studentId = document.getElementById('student_select').value;
    if (studentId) {
        this.action = "{{ url('reports/student') }}/" + studentId;
    } else {
        e.preventDefault();
        alert('Pilih siswa terlebih dahulu');
    }
});

document.getElementById('classReportForm').addEventListener('submit', function(e) {
    const classId = document.getElementById('class_select').value;
    if (classId) {
        this.action = "{{ url('reports/class') }}/" + classId;
    } else {
        e.preventDefault();
        alert('Pilih kelas terlebih dahulu');
    }
});
</script>
@endpush
@endsection
