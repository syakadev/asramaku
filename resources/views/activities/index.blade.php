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

    @if(session('error'))
        <!-- Alpine.js controlled alert -->
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 5000)"
             x-show="show"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="text-red-700 hover:text-red-900">&times;</button>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Kegiatan</h1>
        <a href="{{ route('activities.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
            Tambah Kegiatan
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Desktop Table -->
        <div class="hidden md:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kegiatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyelenggara</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($activities as $activity)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $activity->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activity->location }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($activity->date)->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $activity->type == 1 ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $activity->type == 1 ? 'Wajib' : 'Opsional' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activity->organizer->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('activities.show', $activity) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="md:hidden">
            @foreach($activities as $activity)
            <div class="border-b border-gray-200 last:border-b-0">
                <div class="p-4">
                    <div class="flex items-start space-x-4">
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $activity->name }}</p>
                                    <p class="text-sm text-gray-600 mt-1">Lokasi: <span class="font-semibold text-gray-800">{{ $activity->location }}</span></p>
                                </div>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $activity->type == 1 ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $activity->type == 1 ? 'Wajib' : 'Opsional' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Tanggal: <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($activity->date)->format('d M Y H:i') }}</span></p>
                            <p class="text-sm text-gray-600 mt-1">Penyelenggara: <span class="font-semibold text-gray-800">{{ $activity->organizer->name }}</span></p>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end space-x-3">
                        <a href="{{ route('activities.show', $activity) }}" class="text-sm text-blue-600 hover:text-blue-900">Lihat</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
