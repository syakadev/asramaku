@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Jadwal Piket</h1>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Seksi</label>
            <p class="text-gray-800">{{ $dutySchedule->duty->section }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <p class="text-gray-800">{{ $dutySchedule->duty->description }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Penanggung Jawab</label>
            <p class="text-gray-800">{{ $dutySchedule->user->name }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
            <p class="text-gray-800">{{ \Carbon\Carbon::parse($dutySchedule->start_date)->format('d-m-Y') }}</p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Selesai</label>
            <p class="text-gray-800">{{ \Carbon\Carbon::parse($dutySchedule->end_date)->format('d-m-Y') }}</p>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('dutySchedules.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
