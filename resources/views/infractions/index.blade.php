@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    @if(session('success'))
        <!-- Alpine.js controlled alert -->
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 5000)"
             x-show="show"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="text-green-700 hover:text-green-900">&times;</button>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Pelanggaran</h1>
        <a href="{{ route('infractions.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
            Tambah Pelanggaran
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Denda</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($infractions as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->img)
                            <a href="{{ asset('storage/images/' . $item->img) }}" data-toggle="image-modal">
                                <img src="{{ asset('storage/images/' . $item->img) }}" alt="Gambar Pelanggaran" class="h-12 w-12 object-cover rounded cursor-pointer hover:opacity-75 transition">
                            </a>
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($item->amount, 2, ',', '.') }}</td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $item->status == 'dibayar' ? 'bg-blue-100 text-blue-1000' : 'bg-red-100 text-red-800' }}">
                            {{ $item->status == 'dibayar' ? 'Dibayar' : 'Belum Dibayar' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->reporter_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->user_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('infractions.show', $item) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                            <a href="{{ route('infractions.edit', $item) }}" class="text-green-600 hover:text-green-900">Edit</a>
                            <form action="{{ route('infractions.destroy', $item) }}" method="POST" class="inline">
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

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="relative max-w-4xl max-h-[90vh] overflow-auto rounded-lg">
            <button id="closeModal" class="absolute -top-2 -right-2 md:top-0 md:-right-10 text-white text-4xl font-bold hover:text-gray-300 transition">&times;</button>
            <img id="modalImage" src="" alt="Gambar Pelanggaran Diperbesar" class="object-contain cursor-zoom-in transition-transform duration-300">
        </div>
    </div>
</div>

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
        // Close if clicked on the background overlay
        if (e.target === imageModal) {
            hideModal();
        }
    });

    modalImage.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevent modal from closing when image is clicked
        this.classList.toggle('zoomed');
    });
});
</script>
@endsection
