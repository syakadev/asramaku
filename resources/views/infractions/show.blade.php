@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Pelanggaran</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
                @if($infraction->img)
                    <img src="{{ $infraction->img }}" alt="Gambar Pelanggaran" class="h-48 w-full object-cover rounded-lg shadow">
                @else
                    <span class="text-gray-400">Tidak ada gambar</span>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Pelanggaran</label>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                    {{ $infraction->type == 'piket' ? 'bg-yellow-100 text-yellow-800' : 'bg-purple-100 text-purple-800' }}">
                    {{ $infraction->type == 'piket' ? 'Piket' : 'Kerapian dan Kebersihan' }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                    {{ $infraction->status == 'dibayar' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $infraction->status == 'dibayar' ? 'Dibayar' : 'Belum Dibayar' }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ID Pelapor</label>
                <p class="text-gray-900">{{ $infraction->reporter_id }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ID Pelanggar</label>
                <p class="text-gray-900">{{ $infraction->user_id }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <p class="text-gray-900">{{ $infraction->note ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('infraction.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
