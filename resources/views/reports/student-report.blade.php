<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Raport {{ $student->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #059669; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #059669; }
        .student-info { margin: 20px 0; }
        .student-info table { width: 100%; }
        .student-info td { padding: 5px; }
        .grades-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .grades-table th, .grades-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .grades-table th { background-color: #059669; color: white; }
        .summary { background-color: #f0fdf4; padding: 15px; border-left: 4px solid #059669; margin: 20px 0; }
        .footer { text-align: right; margin-top: 40px; }
        .signature { display: inline-block; width: 200px; text-align: center; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>SMP ISLAM BAHRUL ULUM</h1>
        <p>LAPORAN HASIL BELAJAR SISWA</p>
        <p>Semester {{ $semester }} Tahun Ajaran {{ $academicYear }}</p>
    </div>

    <!-- Student Information -->
    <div class="student-info">
        <table>
            <tr>
                <td width="150"><strong>Nama Siswa</strong></td>
                <td>: {{ $student->name }}</td>
            </tr>
            <tr>
                <td><strong>NIS / NISN</strong></td>
                <td>: {{ $student->nis }} / {{ $student->nisn }}</td>
            </tr>
            <tr>
                <td><strong>Kelas</strong></td>
                <td>: {{ $student->classRoom->name }}</td>
            </tr>
        </table>
    </div>

    <!-- Academic Grades -->
    <h3 style="color: #059669;">A. NILAI AKADEMIK</h3>
    <table class="grades-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Harian</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Rata-rata</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($student->academicGrades as $index => $grade)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $grade->subject->name }}</td>
                <td>{{ number_format($grade->daily_score, 0) }}</td>
                <td>{{ number_format($grade->midterm_score, 0) }}</td>
                <td>{{ number_format($grade->final_score, 0) }}</td>
                <td><strong>{{ number_format($grade->final_grade, 0) }}</strong></td>
                <td>{{ $grade->final_grade >= $grade->subject->kkm ? 'Tuntas' : 'Belum Tuntas' }}</td>
            </tr>
            @endforeach
            <tr style="background-color: #f9fafb; font-weight: bold;">
                <td colspan="5">RATA-RATA AKADEMIK</td>
                <td colspan="2">{{ number_format($student->academicGrades->avg('final_grade'), 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Non-Academic Records -->
    <h3 style="color: #059669;">B. CATATAN NON-AKADEMIK</h3>
    <table class="grades-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Kegiatan</th>
                <th>Nilai/Prestasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($student->nonAcademicRecords as $index => $record)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ ucfirst($record->category) }}</td>
                <td>{{ $record->name }}</td>
                <td>{{ $record->achievement_level ?? number_format($record->score, 0) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #6b7280;">Belum ada catatan non-akademik</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- GA Result Summary -->
    @if($gaResult)
    <div class="summary">
        <h3 style="margin-top: 0; color: #059669;">C. HASIL ANALISIS ALGORITMA GENETIK</h3>
        <table style="width: 100%;">
            <tr>
                <td width="250"><strong>Rata-rata Akademik</strong></td>
                <td>: {{ number_format($gaResult->academic_average, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Rata-rata Non-Akademik</strong></td>
                <td>: {{ number_format($gaResult->non_academic_average, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Skor Tertimbang</strong></td>
                <td>: <strong>{{ number_format($gaResult->weighted_score, 2) }}</strong></td>
            </tr>
            <tr>
                <td><strong>Klasifikasi</strong></td>
                <td>: <strong style="color: #059669;">{{ $gaResult->classification }}</strong></td>
            </tr>
            <tr>
                <td><strong>Rekomendasi</strong></td>
                <td>: {{ $gaResult->recommendation }}</td>
            </tr>
        </table>
    </div>
    @endif

    <!-- Signatures -->
    <div class="footer">
        <div class="signature">
            <p>Wali Kelas,</p>
            <br><br><br>
            <p><strong><u>{{ $student->classRoom->homeroomTeacher->name ?? '_______________' }}</u></strong></p>
            <p>NIP. {{ $student->classRoom->homeroomTeacher->nip ?? '-' }}</p>
        </div>
    </div>
</body>
</html>
