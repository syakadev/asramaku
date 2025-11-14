@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Data Piket</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Seksi</label>
                <p class="text-lg text-gray-900">{{ $duty->section }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <p class="text-gray-900">{{ $duty->description ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-8 flex justify-center items-center space-x-4">
            <a href="{{ route('duties.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Kembali
            </a>
            <a href="{{ route('duties.edit', $duty) }}"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center" title="Edit">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <form action="{{ route('duties.destroy', $duty) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" title="Hapus" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    <i class="fas fa-trash mr-2"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection