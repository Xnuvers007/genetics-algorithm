@extends('layouts.app')

@section('title', 'Detail Hasil GA')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Detail Hasil GA - {{ $result->student->name }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <p><strong>Semester:</strong> {{ $result->semester }}</p>
            <p><strong>Tahun Ajaran:</strong> {{ $result->academic_year }}</p>
            <p><strong>Generasi Dicapai:</strong> {{ $result->generation_reached }}</p>
            <p><strong>Best Fitness:</strong> {{ $result->best_fitness }}</p>
        </div>
        <div>
            <p><strong>Klasifikasi:</strong> <span class="text-emerald-600">{{ $result->classification }}</span></p>
            <p><strong>Rekomendasi:</strong> {{ $result->recommendation }}</p>
        </div>
    </div>

    <div class="mb-6">
        <canvas id="evolutionChart" height="120"></canvas>
    </div>

    <div>
        <a href="{{ route('ga.index') }}" class="inline-block px-4 py-2 bg-gray-200 rounded">Kembali</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Evolution Chart
const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
const evolutionData = @json($result->evolution_data ?? []);

new Chart(evolutionCtx, {
    type: 'line',
    data: {
        labels: evolutionData.map(d => `Gen ${d.generation}`),
        datasets: [{
            label: 'Best Fitness',
            data: evolutionData.map(d => d.best_fitness),
            borderColor: '#059669',
            tension: 0.1,
            fill: false
        }, {
            label: 'Average Fitness',
            data: evolutionData.map(d => d.avg_fitness),
            borderColor: '#3b82f6',
            tension: 0.1,
            fill: false
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Evolusi Fitness per Generasi'
            }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endpush
