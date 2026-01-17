<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kelas {{ $class->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 12px; border-bottom: 3px solid #059669; padding-bottom: 8px; }
        .header h1 { margin: 0; color: #059669; }
        .class-info { margin: 12px 0; }
        .class-info table { width: 100%; }
        .class-info td { padding: 4px; }
        .students-table { width: 100%; border-collapse: collapse; margin: 8px 0; }
        .students-table th, .students-table td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        .students-table th { background-color: #059669; color: white; }
        .summary { background-color: #f0fdf4; padding: 10px; border-left: 4px solid #059669; margin: 12px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMP ISLAM BAHRUL ULUM</h1>
        <p>LAPORAN KELAS {{ strtoupper($class->name) }}</p>
        <p>Semester {{ $semester }} &middot; Tahun Ajaran {{ $academicYear }}</p>
    </div>

    <div class="class-info">
        <table>
            <tr>
                <td width="180"><strong>Nama Kelas</strong></td>
                <td>: {{ $class->name }}</td>
                <td width="180"><strong>Wali Kelas</strong></td>
                <td>: {{ $class->homeroomTeacher->name ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Tingkat</strong></td>
                <td>: {{ $class->grade_level }}</td>
                <td><strong>Jumlah Siswa</strong></td>
                <td>: {{ $class->students->count() }}</td>
            </tr>
        </table>
    </div>

    <h3 style="color: #059669; margin-bottom: 6px;">Daftar Siswa & Hasil GA</h3>
    <table class="students-table">
        <thead>
            <tr>
                <th style="width:40px;">No</th>
                <th style="width:110px;">NIS</th>
                <th>Nama Siswa</th>
                <th style="width:110px;">Rata-rata Akademik</th>
                <th style="width:140px;">Rata-rata Non-Akademik</th>
                <th style="width:120px;">Skor Tertimbang</th>
                <th style="width:120px;">Klasifikasi</th>
                <th style="width:160px;">Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $cnt = 0;
                $sumAcademic = 0;
                $sumNon = 0;
                $sumWeighted = 0;
            @endphp

            @foreach($class->students as $student)
                @php
                    $gr = $student->gaResults->first();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $student->nis ?? '-' }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $gr ? number_format($gr->academic_average, 2) : '-' }}</td>
                    <td>{{ $gr ? number_format($gr->non_academic_average, 2) : '-' }}</td>
                    <td>{{ $gr ? number_format($gr->weighted_score, 2) : '-' }}</td>
                    <td>{{ $gr ? $gr->classification : '-' }}</td>
                    <td style="white-space: pre-line;">{{ $gr ? $gr->recommendation : '-' }}</td>
                </tr>

                @if($gr)
                    @php
                        $cnt++;
                        $sumAcademic += (float) $gr->academic_average;
                        $sumNon += (float) $gr->non_academic_average;
                        $sumWeighted += (float) $gr->weighted_score;
                    @endphp
                @endif
            @endforeach

            @if($class->students->isEmpty())
                <tr>
                    <td colspan="8" style="text-align:center; color:#6b7280;">Tidak ada siswa di kelas ini.</td>
                </tr>
            @endif

            @if($cnt > 0)
                <tr style="background-color:#f9fafb; font-weight:bold;">
                    <td colspan="3">Rata-rata Kelas (berdasarkan hasil GA)</td>
                    <td>{{ number_format($sumAcademic / $cnt, 2) }}</td>
                    <td>{{ number_format($sumNon / $cnt, 2) }}</td>
                    <td>{{ number_format($sumWeighted / $cnt, 2) }}</td>
                    <td colspan="2">&nbsp;</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="summary">
        <strong>Catatan:</strong>
        <p>Jika beberapa siswa belum memiliki hasil GA, pastikan data nilai akademik dan non-akademik untuk semester ini sudah diinputkan lengkap.</p>
    </div>

</body>
</html>
