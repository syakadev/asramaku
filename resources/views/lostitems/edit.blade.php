@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">KAMU INGIN MENGAMBIL BARANG INI?</h1>
    <p class="text-gray-600 mb-6">Pastikan Anda adalah pemilik sah dari barang ini sebelum melanjutkan.</p>


        <form action="{{ route('lostitems.update', $lostitem) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- hidden --}}
            <input type="hidden" name="status" value="taken">
            <input type="hidden" name="reporter_id" value="{{ $lostitem->reporter_id }}">
            <input type="hidden" name="user_id"
            {{-- value="{{ Auth::user()->id }}" --}}
            value="1"
            >
            <input type="hidden" name="date_taken" value="{{ date('Y-m-d') }}">


            <input type="hidden" name="name" id="name" value="{{ old('name', $lostitem->name) }}">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <input type="hidden" name="date_found" id="date_found" value="{{ old('date_found', $lostitem->date_found) }}">
            @error('date_found')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <input type="hidden" name="description" id="description" value="{{ old('description', $lostitem->description) }}">
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <input type="hidden" name="img" id="img" value="{{ old('img', $lostitem->img) }}">
            @error('img')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{route('lostitems.show', $lostitem)}}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition duration-200">Detail Barang</a>

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
