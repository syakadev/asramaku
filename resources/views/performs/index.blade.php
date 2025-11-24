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

    @if(session('error'))
        <!-- Alpine.js controlled alert -->
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 5000)"
             x-show="show"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="text-red-700 hover:text-red-900">&times;</button>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Penilaian Kinerja</h1>
        <a href="{{ route('performs.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
            Tambah Penilaian
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Desktop Table -->
        <div class="hidden md:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal Piket</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($performs as $perform)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($perform->img)
                                <a href="{{ asset('storage/images/' . $perform->img) }}" data-toggle="image-modal">
                                    <img src="{{ asset('storage/images/' . $perform->img) }}" alt="Gambar Kinerja" class="h-12 w-12 object-cover rounded cursor-pointer hover:opacity-75 transition">
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($perform->date)->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $perform->status == 'dilaksanakan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($perform->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $perform->dutyschedule->duty->section }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $perform->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('performs.show', $perform) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="md:hidden">
            @foreach($performs as $perform)
            <div class="border-b border-gray-200 last:border-b-0">
                <div class="p-4">
                    <div class="flex items-start space-x-4">
                        @if($perform->img)
                            <a href="{{ asset('storage/images/' . $perform->img) }}" data-toggle="image-modal">
                                <img src="{{ asset('storage/images/' . $perform->img) }}" alt="Gambar Kinerja" class="h-16 w-16 object-cover rounded cursor-pointer hover:opacity-75 transition">
                            </a>
                        @else
                            <div class="h-16 w-16 bg-gray-100 rounded flex items-center justify-center">
                                <span class="text-gray-400 text-xs">No Image</span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-600">User: <span class="font-semibold text-gray-800">{{ $perform->user_id }}</span></p>
                                    <p class="text-sm text-gray-600 mt-1">Jadwal: <span class="font-semibold text-gray-800">{{ $perform->duty_schedule_id }}</span></p>
                                </div>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $perform->status == 'dilaksanakan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($perform->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Tanggal: <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($perform->date)->format('d M Y') }}</span></p>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end space-x-3">
                        <a href="{{ route('performs.show', $perform) }}" class="text-sm text-blue-600 hover:text-blue-900">Lihat</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="relative max-w-4xl max-h-[90vh] overflow-auto rounded-lg">
            <button id="closeModal" class="absolute -top-2 -right-2 md:top-0 md:-right-10 text-white text-4xl font-bold hover:text-gray-300 transition">&times;</button>
            <img id="modalImage" src="" alt="Gambar Kinerja Diperbesar" class="object-contain cursor-zoom-in transition-transform duration-300">
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
