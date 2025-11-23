@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Penilaian Kinerja</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('performs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <!-- User -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">User yang Dinilai</label>
                    <select id="user_id" name="user_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                        <option value="">Pilih User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Jadwal Piket -->
                <div>
                    <label for="duty_schedule_id" class="block text-sm font-medium text-gray-700 mb-1">Jadwal Piket</label>
                    <select id="duty_schedule_id" name="duty_schedule_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                        <option value="">Pilih Jadwal</option>
                        @foreach($dutySchedules as $schedule)
                            <option value="{{ $schedule->id }}" {{ old('duty_schedule_id') == $schedule->id ? 'selected' : '' }}>{{ $schedule->duty->section }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Penilaian</label>
                    <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                        <option value="dilaksanakan" {{ old('status') == 'dilaksanakan' ? 'selected' : '' }}>Dilaksanakan</option>
                        <option value="tidak dilaksanakan" {{ old('status') == 'tidak dilaksanakan' ? 'selected' : '' }}>Tidak Dilaksanakan</option>
                    </select>
                </div>

                <!-- Gambar -->
                <div>
                    <label for="img" class="block text-sm font-medium text-gray-700 mb-1">Bukti Gambar</label>
                    <div class="mt-1 flex items-center">
                        <input type="file" id="img" name="img" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100"
                        >
                    </div>
                    <p class="mt-2 text-xs text-gray-500">PNG, JPG, GIF up to 2MB.</p>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('performs.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
