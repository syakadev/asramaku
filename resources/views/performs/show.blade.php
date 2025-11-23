@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Penilaian Kinerja</h1>
            <a href="{{ route('performs.index') }}" class="text-blue-600 hover:text-blue-800 transition duration-200">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <div class="space-y-4">
            <!-- Gambar -->
            @if($perform->img)
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Bukti Gambar</h3>
                    <img src="{{ asset('storage/images/' . $perform->img) }}" alt="Gambar Kinerja" class="max-w-full h-auto rounded-lg shadow">
                </div>
            @endif

            <!-- Detail -->
            <div class="border-t border-gray-200 pt-4">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div class="md:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">User yang Dinilai</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $perform->user_id }}</dd>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Jadwal Piket</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $perform->duty_schedule_id }}</dd>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Tanggal Penilaian</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($perform->date)->format('d F Y') }}</dd>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $perform->status == 'dilaksanakan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($perform->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Dibuat pada</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $perform->created_at->format('d F Y, H:i') }}</dd>
                    </div>
                    <div class="md:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Diperbarui pada</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $perform->updated_at->format('d F Y, H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-8 flex justify-end space-x-3 border-t border-gray-200 pt-6">
            <a href="{{ route('performs.edit', $perform) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Edit
            </a>
            <form action="{{ route('performs.destroy', $perform) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
