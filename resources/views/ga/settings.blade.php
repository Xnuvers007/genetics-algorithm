@extends('layouts.app')

@section('title', 'Pengaturan GA')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan Algoritma Genetik</h2>
        
        <form action="{{ route('ga.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800">
                    <strong>Info:</strong> Parameter di bawah ini akan mempengaruhi proses klasifikasi menggunakan algoritma genetik. 
                    Ubah dengan hati-hati untuk mendapatkan hasil optimal.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ukuran Populasi</label>
                    <input type="number" name="population_size" value="{{ old('population_size', $settings->population_size) }}" 
                        min="10" max="200" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Jumlah individu dalam populasi (10-200)</p>
                    @error('population_size')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Maksimum Generasi</label>
                    <input type="number" name="max_generations" value="{{ old('max_generations', $settings->max_generations) }}" 
                        min="10" max="500" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Jumlah iterasi maksimal (10-500)</p>
                    @error('max_generations')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Crossover Rate</label>
                    <input type="number" name="crossover_rate" value="{{ old('crossover_rate', $settings->crossover_rate) }}" 
                        min="0" max="1" step="0.01" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Probabilitas crossover (0-1)</p>
                    @error('crossover_rate')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mutation Rate</label>
                    <input type="number" name="mutation_rate" value="{{ old('mutation_rate', $settings->mutation_rate) }}" 
                        min="0" max="1" step="0.01" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Probabilitas mutasi (0-1)</p>
                    @error('mutation_rate')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            
            <hr class="my-6">
            
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Bobot Penilaian</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bobot Akademik</label>
                    <input type="number" name="academic_weight" value="{{ old('academic_weight', $settings->academic_weight) }}" 
                        min="0" max="1" step="0.1" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Bobot untuk nilai akademik (0-1)</p>
                    @error('academic_weight')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bobot Non-Akademik</label>
                    <input type="number" name="non_academic_weight" value="{{ old('non_academic_weight', $settings->non_academic_weight) }}" 
                        min="0" max="1" step="0.1" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Bobot untuk nilai non-akademik (0-1)</p>
                    @error('non_academic_weight')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-sm text-yellow-800">
                    <strong>Catatan:</strong> Bobot akademik + non-akademik harus berjumlah 1.0
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Target Threshold</label>
                <input type="number" name="target_threshold" value="{{ old('target_threshold', $settings->target_threshold) }}" 
                    min="0" max="100" step="1" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                <p class="mt-1 text-xs text-gray-500">Target fitness minimum untuk berhenti (0-100)</p>
                @error('target_threshold')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('ga.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Kembali</a>
                <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>
@endsection
