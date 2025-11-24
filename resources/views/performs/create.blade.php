@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Absen Piket {{ $user->name }}</h1>

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
                    <input type="hidden" id="user_id" name="user_id"
                    {{-- value="{{ Auth::user()->id }}" --}}
                    value="1"
                    >

                    <input type="hidden" name="status" value="dilaksanakan">
                    <input type="hidden" name="duty_schedule_id" value="{{ $dutySchedules->first()->id }}">

                </div>


                <!-- Jadwal Piket -->
                <div>
                    <h3 for="duty_schedule_id" class="block text-sm font-medium text-gray-700 mb-1">Jadwal Piket</h3>
                    <p>
                            {{ $dutySchedules->first()->duty->section }}
                    </p>
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Penilaian</label>
                    <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required readonly>
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

                    <div style="margin-top: 10px;">
                        <img id="preview" src="" alt="Preview Gambar" width="200" style="display: none;">
                    </div>
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
<script>
    document.getElementById('img').addEventListener('change', function(event) {
        let file = event.target.files[0];
        let preview = document.getElementById('preview');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = "block";
        }
    });
</script>
@endsection


