
@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Show Documentation</h1>
            <a href="{{ route('activities.show', $activity->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back</a>
        </div>

        <div class="mb-4">
                <div class="documentation-item">
                    <p>Aktivitas Induk: {{ $activity->name }}</p>
                </div>
        </div>

        <div class="mb-4">
            <strong class="font-bold">Image:</strong>
            @if ($activity->documentations->count())
                <div class="container mx-auto px-4 py-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Dokumentasi Kegiatan</h3>

                    {{-- DIV utama dengan kelas Tailwind Grid untuk layout --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                        @foreach ($activity->documentations as $documentation)
                            <div class="bg-white rounded-lg shadow-xl overflow-hidden transform hover:scale-105 transition duration-300">
                                <a href="{{ asset('storage/images/documentations/' . $documentation->img) }}" data-toggle="image-modal" data-id="{{ $documentation->id }}">
                                <img
                                    src="{{ asset('storage/images/documentations/' . $documentation->img) }}"
                                    alt="Dokumentasi - {{ $documentation->id }}"
                                    {{-- Kelas untuk memastikan gambar mengisi kotak dan memiliki aspek rasio yang bagus --}}
                                    class="w-full h-64 object-cover">
                                </a>
                                {{-- Opsional: Tambahkan keterangan di bawah gambar --}}
                                {{-- <p class="p-4 text-sm text-gray-600">ID Dok: {{ $documentation->id }}</p> --}}
                            </div>
                        @endforeach

                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                    <p>Tidak ada dokumentasi gambar yang tersedia untuk aktivitas ini.</p>
                </div>
            @endif

        </div>
        <form action="{{ route('documentations.create')}}">
            @csrf
            @method('post')
            <button class="
                fixed             bottom-10          right-10          bg-blue-600       hover:bg-blue-700 text-white        p-4               rounded-full      shadow-lg         transition-all    duration-300
                focus:outline-none
                focus:ring-4      focus:ring-blue-300
                z-50              ">
                <i class="fas fa-plus text-xl"></i>
            </button>
        </form>

            <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="relative max-w-4xl max-h-[90vh] overflow-auto rounded-lg">
            <button id="closeModal" class="absolute -top-2 -right-2 md:top-0 md:-right-10 text-white text-4xl font-bold hover:text-gray-300 transition">&times;</button>
            <form id="deleteForm" action="" method="POST" class="absolute top-2 right-2 z-10">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white p-2 rounded-full opacity-75 hover:opacity-100 transition-opacity duration-300" onclick="return confirm('Are you sure you want to delete this image?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>

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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageModal = document.getElementById('imageModal');
    if (!imageModal) return;

    const modalImage = document.getElementById('modalImage');
    const closeModal = document.getElementById('closeModal');
    const deleteForm = document.getElementById('deleteForm');
    const thumbnailLinks = document.querySelectorAll('a[data-toggle="image-modal"]');

    thumbnailLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const docId = this.dataset.id;
            const deleteUrl = '{{ url("documentations") }}/' + docId;
            deleteForm.action = deleteUrl;
            
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
@endpush
@endsection
