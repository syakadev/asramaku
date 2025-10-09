@extends('layouts.app')

@section('title', 'Dashboard Kas Asrama')
@section('page-title', 'Dashboard Kas Asrama')
@section('breadcrumb', 'Dashboard Kas Asrama')

@section('content')
<div class="container mx-auto px-4 py-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

        <!-- Chart Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Grafik Pemasukan & Pengeluaran</h3>
        </div>
        <div class="h-80">
            <canvas id="financeChart"></canvas>
        </div>
    </div>


        <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h3 class="text-lg font-semibold text-gray-800">Filter Data</h3>

            <form method="GET" action="{{ route('dormfunds.index') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Filter Type -->
                <select name="filter_type" id="filter_type"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all" {{ request('filter_type') == 'all' ? 'selected' : '' }}>Semua Data</option>
                    <option value="month" {{ request('filter_type') == 'month' ? 'selected' : '' }}>Berdasarkan Bulan</option>
                    <option value="range" {{ request('filter_type') == 'range' ? 'selected' : '' }}>Rentang Tanggal</option>
                </select>

                <!-- Month Filter (hidden by default) -->
                <div id="month_filter" class="hidden">
                    <div class="flex gap-2">
                        <select name="month" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                        <select name="year" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @for($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Date Range Filter (hidden by default) -->
                <div id="range_filter" class="hidden">
                    <div class="flex gap-2">
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <span class="flex items-center text-gray-500">s/d</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        Terapkan
                    </button>
                    <a href="{{ route('dormfunds.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition duration-200">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Saldo -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Saldo</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">
                        Rp {{ number_format($totalSaldo, 2, ',', '.') }}
                    </p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-wallet text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500">Saldo akhir bulan ini</span>
            </div>
        </div>

        <!-- Total Pemasukan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">
                        Rp {{ number_format($totalPemasukan, 2, ',', '.') }}
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-arrow-down text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500">Pemasukan bulan ini</span>
            </div>
        </div>

        <!-- Total Pengeluaran -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">
                        Rp {{ number_format($totalPengeluaran, 2, ',', '.') }}
                    </p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-arrow-up text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500">Pengeluaran bulan ini</span>
            </div>
        </div>
    </div>




    <!-- Header Table -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Data Kas Asrama</h1>
        <a href="{{ route('dormfunds.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center justify-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Data Kas
        </a>
    </div>

    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($dormFunds as $dormFund)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $dormFund->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $dormFund->date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $dormFund->status == 'pemasukan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $dormFund->status == 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
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
                               class="text-blue-600 hover:text-blue-900 transition duration-150">
                                <i class="fas fa-eye mr-1"></i>Lihat
                            </a>
                            <a href="{{ route('dormfunds.edit', $dormFund) }}"
                               class="text-green-600 hover:text-green-900 transition duration-150">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form action="{{ route('dormfunds.destroy', $dormFund) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:text-red-900 transition duration-150"
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

    <!-- Mobile Table -->
    <div class="md:hidden bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($dormFunds as $dormFund)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $dormFund->date }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $dormFund->status == 'pemasukan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $dormFund->status == 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
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

<!-- Detail Modal for Mobile -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Detail Transaksi</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div id="modalContent">
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
const ctx = document.getElementById('financeChart').getContext('2d');
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

// Mobile Modal Functions
function showDetailModal(id) {
    // In a real application, you would fetch this data via AJAX
    // For now, we'll use the existing data
    const dormFund = {!! json_encode($dormFunds->keyBy('id')) !!}[id];

    if (dormFund) {
        const modalContent = document.getElementById('modalContent');
        modalContent.innerHTML = `
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <p class="text-gray-900 font-semibold">${dormFund.title}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <p class="text-gray-900">${dormFund.date}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                        ${dormFund.status == 'pemasukan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                        ${dormFund.status == 'pemasukan' ? 'Pemasukan' : 'Pengeluaran'}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Saldo</label>
                    <p class="text-lg font-bold text-gray-900">
                        Rp ${new Intl.NumberFormat('id-ID', {minimumFractionDigits: 2}).format(dormFund.amount)}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <p class="text-gray-900">${dormFund.note || '-'}</p>
                </div>

                <div class="flex space-x-3 pt-4 border-t border-gray-200">
                    <a href="/dormfunds/${dormFund.id}"
                       class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-eye mr-2"></i>Lihat Detail
                    </a>
                    <a href="/dormfunds/${dormFund.id}/edit"
                       class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                </div>

                <form action="/dormfunds/${dormFund.id}" method="POST" class="pt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center"
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
</style>
@endsection
