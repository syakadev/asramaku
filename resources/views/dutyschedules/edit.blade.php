@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Ubah Jadwal Piket</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dutySchedules.update', $dutySchedule) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="duty_id" class="block text-gray-700 text-sm font-bold mb-2">Seksi</label>
                <select name="duty_id" id="duty_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Pilih Seksi</option>
                    @foreach($duties as $duty)
                        <option value="{{ $duty->id }}" {{ $dutySchedule->duty_id == $duty->id ? 'selected' : '' }}>{{ $duty->section }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Penanggung Jawab</label>
                <select name="user_id" id="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Pilih Penanggung Jawab</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $dutySchedule->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{  \Carbon\Carbon::parse($dutySchedule->start_date)->format('Y-m-d') }}" required>
            </div>

            <div class="mb-6">
                <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ \Carbon\Carbon::parse($dutySchedule->end_date)->format('Y-m-d') }}" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan Perubahan
                </button>
                <a href="{{ route('dutySchedules.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
