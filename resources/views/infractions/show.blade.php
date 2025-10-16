@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Pelanggaran</h1>

    <div class="bg-white rounded-lg shadow p-6 ">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
                @if($infraction->img)
                    <a href="{{ asset('storage/images/' . $infraction->img) }}" data-toggle="image-modal">
                    <img src="{{ asset('storage/images/' . $infraction->img) }}" alt="Gambar Pelanggaran" class="h-60 w-full object-cover rounded-lg shadow cursor-pointer hover:opacity-75 transition">
                    </a>
                @else
                    <span class="text-gray-400">Tidak ada gambar</span>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Pelanggaran</label>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                    {{ $infraction->type == 'piket' ? 'bg-yellow-100 text-yellow-800' : 'bg-purple-100 text-purple-800' }}">
                    {{ $infraction->type == 'piket' ? 'Piket' : 'Kerapian dan Kebersihan' }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                    {{ $infraction->status == 'dibayar' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                    {{ $infraction->status == 'dibayar' ? 'Dibayar' : 'Belum Dibayar' }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ID Pelapor</label>
                <p class="text-gray-900">{{ $infraction->reporter_id }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ID Pelanggar</label>
                <p class="text-gray-900">{{ $infraction->user_id }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <p class="text-gray-900">{{ $infraction->note ?? '-' }}</p>
            </div>
        </div>

       <div class="mt-8 flex justify-center items-center space-x-4">
            <a href="{{ route('infractions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 text-center">
                Kembali
            </a>
            <a href="{{ route('infractions.edit', $infraction) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200 text-center">
                Edit
            </a>
            <form action="{{ route('infractions.destroy', $infraction) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    Hapus
                </button>
            </form>
        </div>

    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="relative max-w-4xl max-h-[90vh] overflow-auto rounded-lg">
            <button id="closeModal" class="absolute -top-2 -right-2 md:top-0 md:-right-10 text-white text-4xl font-bold hover:text-gray-300 transition">&times;</button>
            <img id="modalImage" src="" alt="Gambar Pelanggaran Diperbesar" class="object-contain cursor-zoom-in transition-transform duration-300">
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    #modalImage.zoomed {
        transform: scale(2);
        cursor: zoom-out;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageModal = document.getElementById('imageModal');
    if (!imageModal) return;

    const modalImage = document.getElementById('modalImage');
    const closeModal = document.getElementById('closeModal');
    const thumbnailLinks = document.querySelectorAll('a[data-toggle="image-modal"]');

    thumbnailLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            modalImage.src = this.href;
            imageModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        });
    });

    function hideModal() {
        imageModal.classList.add('hidden');
        modalImage.src = ''; // Clear src to prevent showing old image briefly
        modalImage.classList.remove('zoomed'); // Reset zoom state
        document.body.style.overflow = ''; // Restore background scrolling
    }

    closeModal.addEventListener('click', hideModal);

    imageModal.addEventListener('click', function(e) {
        if (e.target === imageModal) { // Close if clicked on the background overlay
            hideModal();
        }
    });

    modalImage.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevent modal from closing when image is clicked
        this.classList.toggle('zoomed');
    });
});
</script>
@endpush
