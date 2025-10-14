@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Data Kas</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                <p class="text-lg text-gray-900">{{ $dormfund->title }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <p class="text-gray-900">{{ $dormfund->note ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Saldo</label>
                <p class="text-lg font-semibold {{ $dormfund->status == 'pemasukan' ? 'text-blue-600' : 'text-red-600' }}">
                    Rp {{ number_format($dormfund->amount, 2, ',', '.') }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <p class="text-gray-900">{{ $dormfund->date }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                    {{ $dormfund->status == 'pemasukan' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                    {{ $dormfund->status == 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}
                </span>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('dormfunds.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
