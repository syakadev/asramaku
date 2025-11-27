@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Kegiatan</h1>
            <a href="{{ route('activities.index') }}" class="text-blue-600 hover:text-blue-800 transition duration-200">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <div class="space-y-4">
            <!-- Gambar -->
            @if($activity->img)
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Dokumentasi</h3>
                    <img src="{{ asset('storage/images/' . $activity->img) }}" alt="Gambar Kegiatan" class="max-w-full h-auto rounded-lg shadow">
                </div>
            @endif

            <!-- Detail -->
            <div class="border-t border-gray-200 pt-4">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Nama Kegiatan</dt>
                        <dd class="mt-1 text-lg text-gray-900 font-semibold">{{ $activity->name }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $activity->description }}</dd>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Lokasi</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $activity->location }}</dd>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Tanggal & Waktu</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($activity->date)->format('d F Y, H:i') }}</dd>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Tipe</dt>
                        <dd class="mt-1 text-sm">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $activity->type == 1 ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $activity->type == 1 ? 'Wajib' : 'Opsional' }}
                            </span>
                        </dd>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Penyelenggara</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $activity->organizer->name }}</dd>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Dibuat pada</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $activity->created_at->format('d F Y, H:i') }}</dd>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Diperbarui pada</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $activity->updated_at->format('d F Y, H:i') }}</dd>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="mt-1 text-sm text-blue-700">
                            <a href="{{ route('documentations', $activity) }}">
                                Dokumentasi {{ $activity->name }}
                            </a>
                        </dt>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="mt-1 text-sm text-blue-700">
                            <a href="{{ route('attendances.index') }}">Daftar Hadir</a>
                        </dt>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-8 flex justify-end space-x-3 border-t border-gray-200 pt-6">
            <a href="{{ route('activities.edit', $activity) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Edit
            </a>
            <form action="{{ route('activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
