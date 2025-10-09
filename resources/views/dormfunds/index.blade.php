@extends('layouts.app')

@section('title', 'Dashboard Kas Asrama')
@section('page-title', 'Dashboard Kas Asrama')
@section('breadcrumb', 'Dashboard Kas Asrama')

@section('content')
<div class="mx-auto px-4 py-6 max-w-7xl">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 max-w-full overflow-hidden">
            {{ session('success') }}
        </div>
    @endif

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 max-w-full">
        <!-- Total Saldo -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-600 truncate">Total Saldo</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2 truncate">
                        Rp {{ number_format($totalSaldo, 2, ',', '.') }}
                    </p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full flex-shrink-0 ml-4">
                    <i class="fas fa-wallet text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500 truncate">Saldo akhir bulan ini</span>
            </div>
        </div>

        <!-- Total Pemasukan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-600 truncate">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2 truncate">
                        Rp {{ number_format($totalPemasukan, 2, ',', '.') }}
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-full flex-shrink-0 ml-4">
                    <i class="fas fa-arrow-up text-green-600 text-xl"></i> <!-- DIUBAH: arrow-up untuk pemasukan -->
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500 truncate">Total pemasukan hingga saat ini</span> <!-- DIUBAH: deskripsi -->
            </div>
        </div>

        <!-- Total Pengeluaran -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500 overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-600 truncate">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2 truncate">
                        Rp {{ number_format($totalPengeluaran, 2, ',', '.') }}
                    </p>
                </div>
                <div class="bg-red-100 p-3 rounded-full flex-shrink-0 ml-4">
                    <i class="fas fa-arrow-down text-red-600 text-xl"></i> <!-- DIUBAH: arrow-down untuk pengeluaran -->
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500 truncate">Total pengeluaran hingga saat ini</span> <!-- DIUBAH: deskripsi -->
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8 max-w-full overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h3 class="text-lg font-semibold text-gray-800 truncate">Filter Data</h3>

            <form method="GET" action="{{ route('dormfunds.index') }}" class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                <!-- Filter Type -->
                <select name="filter_type" id="filter_type"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-auto min-w-[150px]">
                    <option value="all" {{ request('filter_type') == 'all' ? 'selected' : '' }}>Semua Data</option>
                    <option value="month" {{ request('filter_type') == 'month' ? 'selected' : '' }}>Berdasarkan Bulan</option>
                    <option value="range" {{ request('filter_type') == 'range' ? 'selected' : '' }}>Rentang Tanggal</option>
                </select>

                <!-- Month Filter (hidden by default) -->
                <div id="month_filter" class="hidden w-full md:w-auto">
                    <div class="flex flex-col sm:flex-row gap-2 w-full">
                        <select name="month" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-auto flex-1">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                        <select name="year" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-auto flex-1">
                            @for($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Date Range Filter (hidden by default) -->
                <div id="range_filter" class="hidden w-full md:w-auto">
                    <div class="flex flex-col sm:flex-row gap-2 w-full items-center">
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-auto flex-1">
                        <span class="flex items-center text-gray-500 text-sm">s/d</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-auto flex-1">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200 w-full md:w-auto">
                        Terapkan
                    </button>
                    <a href="{{ route('dormfunds.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition duration-200 text-center w-full md:w-auto">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8 max-w-full overflow-hidden">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Grafik Pemasukan & Pengeluaran</h3>
        </div>
        <div class="h-80 w-full">
            <canvas id="financeChart"></canvas>
        </div>
    </div>

    <!-- Header Table -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 max-w-full">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0 truncate">Data Kas Asrama</h1>
        <a href="{{ route('dormfunds.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center justify-center w-full md:w-auto">
            <i class="fas fa-plus mr-2"></i>
            Tambah Data Kas
        </a>
    </div>

    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-xl shadow-sm overflow-hidden max-w-full">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Judul</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Saldo</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Keterangan</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($dormFunds as $dormFund)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 max-w-xs truncate">{{ $dormFund->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $dormFund->date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($dormFund->status == 'pemasukan')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200 whitespace-nowrap">
                                    <i class="fas fa-arrow-up mr-1 text-xs"></i> <!-- DIUBAH: tambah ikon -->
                                    Pemasukan
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200 whitespace-nowrap">
                                    <i class="fas fa-arrow-down mr-1 text-xs"></i> <!-- DIUBAH: tambah ikon -->
                                    Pengeluaran
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            Rp {{ number_format($dormFund->amount, 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                            {{ $dormFund->note ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                <a href="{{ route('dormfunds.show', $dormFund) }}"
                                   class="text-blue-600 hover:text-blue-900 transition duration-150 whitespace-nowrap">
                                    <i class="fas fa-eye mr-1"></i>Lihat
                                </a>
                                <a href="{{ route('dormfunds.edit', $dormFund) }}"
                                   class="text-green-600 hover:text-green-900 transition duration-150 whitespace-nowrap">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <form action="{{ route('dormfunds.destroy', $dormFund) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 transition duration-150 whitespace-nowrap"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Table -->
    <div class="md:hidden bg-white rounded-xl shadow-sm overflow-hidden max-w-full">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Saldo</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($dormFunds as $dormFund)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $dormFund->date }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            @if($dormFund->status == 'pemasukan')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200 whitespace-nowrap">
                                    <i class="fas fa-arrow-up mr-1 text-xs"></i> <!-- DIUBAH: tambah ikon -->
                                    Masuk
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200 whitespace-nowrap">
                                    <i class="fas fa-arrow-down mr-1 text-xs"></i> <!-- DIUBAH: tambah ikon -->
                                    Keluar
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">
                            Rp {{ number_format($dormFund->amount, 2, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                            <button onclick="showDetailModal({{ $dormFund->id }})"
                                class="text-blue-600 hover:text-blue-900 transition duration-150">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detail Modal for Mobile -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full max-h-[90vh] overflow-y-auto mx-2">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 truncate">Detail Transaksi</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 flex-shrink-0 ml-4">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div id="modalContent" class="max-w-full">
                <!-- Content will be loaded via JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Filter Toggle Logic
document.addEventListener('DOMContentLoaded', function() {
    const filterType = document.getElementById('filter_type');
    const monthFilter = document.getElementById('month_filter');
    const rangeFilter = document.getElementById('range_filter');

    function toggleFilters() {
        const value = filterType.value;

        monthFilter.classList.add('hidden');
        rangeFilter.classList.add('hidden');

        if (value === 'month') {
            monthFilter.classList.remove('hidden');
        } else if (value === 'range') {
            rangeFilter.classList.remove('hidden');
        }
    }

    filterType.addEventListener('change', toggleFilters);
    toggleFilters(); // Initialize on page load
});

// Chart.js Implementation
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('financeChart');
    if (ctx) {
        const financeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: {!! json_encode($chartPemasukan) !!},
                        backgroundColor: '#10B981',
                        borderColor: '#059669',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($chartPengeluaran) !!},
                        backgroundColor: '#EF4444',
                        borderColor: '#DC2626',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
});

// Mobile Modal Functions
function showDetailModal(id) {
    const dormFund = {!! json_encode($dormFunds->keyBy('id')) !!}[id];

    if (dormFund) {
        const modalContent = document.getElementById('modalContent');
        modalContent.innerHTML = `
            <div class="space-y-4 max-w-full">
                <div class="break-words">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <p class="text-gray-900 font-semibold break-words">${dormFund.title}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <p class="text-gray-900">${dormFund.date}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                        ${dormFund.status == 'pemasukan' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'}">
                        <i class="fas ${dormFund.status == 'pemasukan' ? 'fa-arrow-up' : 'fa-arrow-down'} mr-1 text-xs"></i>
                        ${dormFund.status == 'pemasukan' ? 'Pemasukan' : 'Pengeluaran'}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Saldo</label>
                    <p class="text-lg font-bold text-gray-900 break-words">
                        Rp ${new Intl.NumberFormat('id-ID', {minimumFractionDigits: 2}).format(dormFund.amount)}
                    </p>
                </div>

                <div class="break-words">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <p class="text-gray-900 break-words">${dormFund.note || '-'}</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                    <a href="/dormfunds/${dormFund.id}"
                       class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded-lg transition duration-200 whitespace-nowrap">
                        <i class="fas fa-eye mr-2"></i>Lihat Detail
                    </a>
                    <a href="/dormfunds/${dormFund.id}/edit"
                       class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center py-2 px-4 rounded-lg transition duration-200 whitespace-nowrap">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                </div>

                <form action="/dormfunds/${dormFund.id}" method="POST" class="pt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center whitespace-nowrap"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <i class="fas fa-trash mr-2"></i>Hapus Data
                    </button>
                </form>
            </div>
        `;

        document.getElementById('detailModal').classList.remove('hidden');
    }
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDetailModal();
    }
});

// Prevent horizontal scroll on body
document.addEventListener('DOMContentLoaded', function() {
    document.body.style.overflowX = 'hidden';
});
</script>

<style>
/* Custom scrollbar for modal */
#detailModal .bg-white::-webkit-scrollbar {
    width: 6px;
}

#detailModal .bg-white::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#detailModal .bg-white::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

#detailModal .bg-white::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Ensure no horizontal overflow */
body {
    overflow-x: hidden;
}

/* Responsive text sizing */
@media (max-width: 640px) {
    .text-2xl {
        font-size: 1.5rem;
        line-height: 2rem;
    }
}
</style>
@endsection
