@extends('layouts.app_transaksi')

@section('title', 'Dashboard Transaksi')
@section('subtitle', 'Overview sistem inventory dan transaksi')

@section('content')
<div class="space-y-6">

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Barang -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <i class="fas fa-box text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Barang</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_barang'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Vendor -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <i class="fas fa-truck text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Vendor</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_vendor'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Stok Menipis -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-orange-100 text-orange-600">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Stok Menipis</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['stok_menipis'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Penjualan Hari Ini -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Penjualan Hari Ini</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['transaksi_hari_ini'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Barang Stok Menipis -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Barang Stok Menipis</h3>
                <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">
                    {{ $lowStockItems->count() }} items
                </span>
            </div>
            <div class="space-y-3">
                @forelse($lowStockItems as $barang)
                <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-900">{{ $barang->nama_barang }}</h4>
                        <p class="text-sm text-gray-500">
                            Stok: {{ $barang->stok_sekarang }} 
                            @if($barang->stok_minimal)
                            / Minimal: {{ $barang->stok_minimal }}
                            @endif
                        </p>
                    </div>
                    <span class="px-2 py-1 bg-orange-500 text-white text-xs rounded-full">
                        Menipis
                    </span>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    <i class="fas fa-check-circle text-green-500 text-2xl mb-2"></i>
                    <p>Semua stok aman</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-3">
                @forelse($recentActivities as $aktivitas)
                <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="p-2 rounded-lg 
                            @if($aktivitas->tipe == 'PENGADAAN') bg-blue-100 text-blue-600
                            @elseif($aktivitas->tipe == 'PENERIMAAN') bg-orange-100 text-orange-600
                            @else bg-green-100 text-green-600 @endif">
                            <i class="{{ $aktivitas->icon ?? 'fas fa-circle' }}"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="font-medium text-gray-900">{{ $aktivitas->nomor }}</h4>
                            <p class="text-sm text-gray-500">{{ $aktivitas->tipe }} • {{ \Carbon\Carbon::parse($aktivitas->tanggal)->format('d M Y') }}</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 
                        @if($aktivitas->status == 'SELESAI' || $aktivitas->status == 'LUNAS') bg-green-100 text-green-800
                        @elseif($aktivitas->status == 'PROSES' || $aktivitas->status == 'DIPROSES') bg-yellow-100 text-yellow-800
                        @elseif($aktivitas->status == 'DISETUJUI') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800 @endif 
                        text-xs rounded-full font-medium">
                        {{ $aktivitas->status }}
                    </span>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    <i class="fas fa-history text-2xl mb-2"></i>
                    <p>Tidak ada aktivitas</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Performance Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Total Penjualan -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total Penjualan</h3>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_penjualan'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm text-gray-500">Total Transaksi: {{ $stats['total_transaksi'] ?? 0 }}</p>
            </div>
        </div>

        <!-- Total Margin -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total Margin</h3>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_margin'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm text-gray-500">Persentase: {{ number_format($stats['persentase_margin'] ?? 0, 2) }}%</p>
            </div>
        </div>

        <!-- Rata-rata Transaksi -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Rata-rata Transaksi</h3>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['rata_rata_transaksi'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <i class="fas fa-calculator text-xl"></i>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm text-gray-500">Per transaksi</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('laporan.barang') }}" 
               class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors group">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mb-2 group-hover:bg-blue-200 transition-colors">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Laporan Barang</span>
            </a>

            <a href="{{ route('pengadaan.create') }}" 
               class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors group">
                <div class="p-3 rounded-lg bg-green-100 text-green-600 mb-2 group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Pengadaan</span>
            </a>

            <a href="{{ route('penerimaan.create') }}" 
               class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors group">
                <div class="p-3 rounded-lg bg-orange-100 text-orange-600 mb-2 group-hover:bg-orange-200 transition-colors">
                    <i class="fas fa-truck-loading"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Penerimaan</span>
            </a>

            <a href="{{ route('penjualan.create') }}" 
               class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors group">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mb-2 group-hover:bg-purple-200 transition-colors">
                    <i class="fas fa-cash-register"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Penjualan</span>
            </a>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Produk Terlaris -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Produk Terlaris</h3>
            <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg">
                <div class="text-center">
                    <i class="fas fa-crown text-yellow-500 text-2xl mb-2"></i>
                    <p class="font-medium text-gray-900">{{ $stats['produk_terlaris'] ?? 'Tidak ada data' }}</p>
                </div>
            </div>
        </div>

        <!-- Kategori Populer -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Kategori Populer</h3>
            <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg">
                <div class="text-center">
                    <i class="fas fa-star text-blue-500 text-2xl mb-2"></i>
                    <p class="font-medium text-gray-900">{{ $stats['kategori_populer'] ?? 'Tidak ada data' }}</p>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Real-time Update Script -->
@push('scripts')
<script>
    // Function untuk update data real-time
    function updateRealTimeData() {
        fetch('{{ route("dashboard.transaksi") }}/real-time')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update elements dengan data real-time
                    document.querySelector('[data-stat="transaksi-hari-ini"]').textContent = data.data.transaksi_hari_ini;
                    document.querySelector('[data-stat="stok-menipis"]').textContent = data.data.stok_menipis;
                    // Tambahkan update untuk elemen lainnya sesuai kebutuhan
                }
            })
            .catch(error => console.error('Error fetching real-time data:', error));
    }

    // Update setiap 30 detik
    setInterval(updateRealTimeData, 30000);

    // Jalankan pertama kali
    document.addEventListener('DOMContentLoaded', function() {
        updateRealTimeData();
    });
</script>
@endpush
@endsection