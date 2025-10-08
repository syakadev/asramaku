@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Pelanggaran</h1>
        <a href="{{ route('infraction.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
            Tambah Pelanggaran
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($infraction as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->img)
                            <img src="{{ $item->img }}" alt="Gambar Pelanggaran" class="h-12 w-12 object-cover rounded">
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $item->type == 'piket' ? 'bg-yellow-100 text-yellow-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $item->type == 'piket' ? 'Piket' : 'Kerapian dan Kebersihan' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $item->status == 'dibayar' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->status == 'dibayar' ? 'Dibayar' : 'Belum Dibayar' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->reporter_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->user_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('infraction.show', $item) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                            <a href="{{ route('infraction.edit', $item) }}" class="text-green-600 hover:text-green-900">Edit</a>
                            <form action="{{ route('infraction.destroy', $item) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
