@extends('layouts.app_transaksi')

@section('title', 'Laporan Stok Barang')
@section('subtitle', 'Menampilkan stok akhir setiap barang berdasarkan view laporan_barang_vu.')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    <!-- Header dengan Filter -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 space-y-4 lg:space-y-0">
        <div>
            <h2 class="text-lg font-semibold text-gray-700">Daftar Barang & Stok Akhir</h2>
            <p class="text-sm text-gray-500">Total: {{ $laporanBarang->count() }} barang</p>
        </div>
        
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
            <a href="{{ route('dashboard.transaksi') }}"
               class="flex items-center px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors text-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    @if(isset($summary))
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <div class="flex items-center">
                <i class="fas fa-box text-blue-600 mr-3"></i>
                <div>
                    <p class="text-sm text-blue-600">Total Barang</p>
                    <p class="text-xl font-bold text-blue-900">{{ $summary['total_barang'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                <div>
                    <p class="text-sm text-green-600">Stok Aman</p>
                    <p class="text-xl font-bold text-green-900">{{ $summary['stok_aman'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-orange-600 mr-3"></i>
                <div>
                    <p class="text-sm text-orange-600">Stok Menipis</p>
                    <p class="text-xl font-bold text-orange-900">{{ $summary['stok_menipis'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
            <div class="flex items-center">
                <i class="fas fa-times-circle text-red-600 mr-3"></i>
                <div>
                    <p class="text-sm text-red-600">Stok Habis</p>
                    <p class="text-xl font-bold text-red-900">{{ $summary['stok_habis'] }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">ID Barang</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama Barang</th>
                    <th class="px-4 py-3 text-center font-semibold">Stok Akhir</th>
                    <th class="px-4 py-3 text-center font-semibold">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporanBarang as $b)
                    <tr class="border-t hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-mono text-gray-600">{{ $b->idbarang }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $b->nama_barang }}</div>
                            @if(isset($b->kode_barang))
                            <div class="text-sm text-gray-500">{{ $b->kode_barang }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center font-semibold text-gray-800">
                            {{ number_format($b->stok_akhir ?? $b->stok_sekarang, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $status = $b->status_stok ?? 'AMAN';
                                $colorClass = [
                                    'AMAN' => 'bg-green-100 text-green-800',
                                    'STOK MENIPIS' => 'bg-orange-100 text-orange-800',
                                    'HABIS' => 'bg-red-100 text-red-800'
                                ][$status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
                                {{ $status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-2"></i>
                            <p>Tidak ada data barang.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection