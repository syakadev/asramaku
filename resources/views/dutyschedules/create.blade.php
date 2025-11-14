@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Jadwal Piket</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dutySchedules.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="duty_id" class="block text-gray-700 text-sm font-bold mb-2">Seksi</label>
                <select name="duty_id" id="duty_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Pilih Seksi</option>
                    @foreach($duties as $duty)
                        <option value="{{ $duty->id }}">{{ $duty->section }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Penanggung Jawab</label>
                <select name="user_id" id="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Pilih Penanggung Jawab</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="period" class="block text-gray-700 text-sm font-bold mb-2">Periode</label>
                <input type="text" name="period" id="period" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: 2023-2024" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan
                </button>
                <a href="{{ route('dutySchedules.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
