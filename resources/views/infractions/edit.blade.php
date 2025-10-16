@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Pelanggaran</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('infractions.update', $infraction) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="img" class="block text-sm font-medium text-gray-700 mb-2">Foto (Opsional)</label>
                    @if($infraction->img)
                        <div class="mb-4">
                            <img src="{{ asset('storage/images/' . $infraction->img) }}" alt="Current Image" class="h-32 w-32 object-cover rounded-md shadow-sm">
                            <p class="text-sm text-gray-500 mt-1">Current image</p>
                        </div>
                    @endif
                    <input type="file" name="img" id="img" accept="image/*" capture="environment"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Pilih gambar baru">
                    @error('img')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Pelanggaran *</label>
                    <select name="type" id="type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Tipe</option>
                        <option value="piket" {{ old('type', $infraction->type) == 'piket' ? 'selected' : '' }}>Piket</option>
                        <option value="kerapian dan kebersihan" {{ old('type', $infraction->type) == 'kerapian dan kebersihan' ? 'selected' : '' }}>Kerapian dan Kebersihan</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reporter_id" class="block text-sm font-medium text-gray-700 mb-2">ID Pelapor *</label>
                    <input type="number" name="reporter_id" id="reporter_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('reporter_id', $infraction->reporter_id) }}">
                    @error('reporter_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">ID Pelanggar *</label>
                    <input type="number" name="user_id" id="user_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('user_id', $infraction->user_id) }}">
                    @error('user_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select name="status" id="status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Status</option>
                        <option value="dibayar" {{ old('status', $infraction->status) == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                        <option value="belum dibayar" {{ old('status', $infraction->status) == 'belum dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Denda *</label>
                    <input type="number" name="amount" id="amount" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('amount', $infraction->amount) }}">
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>



                <div class="md:col-span-2">
                    <label for="note" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                    <textarea name="note" id="note" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('note', $infraction->note) }}</textarea>
                    @error('note')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('infractions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
