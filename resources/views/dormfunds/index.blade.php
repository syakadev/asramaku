@extends('layouts.app')

@section('content')
@section('page-title', 'Dashboard Kas Asrama')
@section('breadcrumb', 'Dashboard Kas Asrama')


<div class="container mx-auto px-4 py-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Kas Asrama</h1>
        <a href="{{ route('dormfunds.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
            Tambah Data Kas
        </a>
    </div>

    <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden"> {{-- Desktop View --}}
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($dormFunds as $dormFund)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $dormFund->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $dormFund->date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $dormFund->status == 'pemasukan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $dormFund->status == 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        Rp {{ number_format($dormFund->balance, 2, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('dormfunds.show', $dormFund) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                            <a href="{{ route('dormfunds.edit', $dormFund) }}" class="text-green-600 hover:text-green-900">Edit</a>
                            <form action="{{ route('dormfunds.destroy', $dormFund) }}" method="POST" class="inline">
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

    <div class="grid grid-cols-1 gap-4 md:hidden"> {{-- Mobile Card View --}}
        @foreach($dormFunds as $dormFund)
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold text-gray-800">{{ $dormFund->title }}</h3>
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                    {{ $dormFund->status == 'pemasukan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $dormFund->status == 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}
                </span>
            </div>
            <p class="text-sm text-gray-600 mb-2">Tanggal: {{ $dormFund->date }}</p>
            <p class="text-md font-bold text-gray-900 mb-4">Saldo: Rp {{ number_format($dormFund->balance, 2, ',', '.') }}</p>
            <div class="flex space-x-2">
                <a href="{{ route('dormfunds.show', $dormFund) }}" class="text-blue-600 hover:text-blue-900 text-sm">Lihat</a>
                <a href="{{ route('dormfunds.edit', $dormFund) }}" class="text-green-600 hover:text-green-900 text-sm">Edit</a>
                <form action="{{ route('dormfunds.destroy', $dormFund) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
