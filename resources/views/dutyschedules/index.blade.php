@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    @if(session('success'))
        <!-- Alpine.js controlled alert -->
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 5000)"
             x-show="show"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="text-green-700 hover:text-green-900">&times;</button>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Jadwal Piket</h1>
        <a href="{{ route('dutySchedules.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
            Tambah Jadwal
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Desktop Table -->
        <div class="hidden md:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penanggung Jawab</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($dutySchedules as $dutySchedule)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $dutySchedule->duty->section }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $dutySchedule->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $dutySchedule->period }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('dutySchedules.show', $dutySchedule) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                <a href="{{ route('dutySchedules.edit', $dutySchedule) }}" class="text-yellow-600 hover:text-yellow-900">Ubah</a>
                                <form action="{{ route('dutySchedules.destroy', $dutySchedule) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="md:hidden">
            @foreach($dutySchedules as $dutySchedule)
            <div class="border-b border-gray-200 last:border-b-0">
                <div class="p-4">
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Seksi: <span class="font-semibold text-gray-800">{{ $dutySchedule->duty->section }}</span></p>
                        <p class="text-sm text-gray-600 mt-1">Penanggung Jawab: <span class="font-semibold text-gray-800">{{ $dutySchedule->user->name }}</span></p>
                        <p class="text-sm text-gray-600 mt-1">Periode: <span class="font-semibold text-gray-800">{{ $dutySchedule->period }}</span></p>
                    </div>
                    <div class="mt-4 flex justify-end space-x-3">
                        <a href="{{ route('dutySchedules.show', $dutySchedule) }}" class="text-sm text-blue-600 hover:text-blue-900">Lihat</a>
                        <a href="{{ route('dutySchedules.edit', $dutySchedule) }}" class="text-sm text-yellow-600 hover:text-yellow-900">Ubah</a>
                        <form action="{{ route('dutySchedules.destroy', $dutySchedule) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
