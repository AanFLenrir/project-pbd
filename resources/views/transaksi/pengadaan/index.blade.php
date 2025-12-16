@extends('layouts.app_transaksi')

@section('title', 'Data Pengadaan')
@section('subtitle', 'Daftar semua pengadaan barang')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    <!-- Header dengan Tombol Tambah -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 space-y-4 lg:space-y-0">
        <div>
            <h2 class="text-lg font-semibold text-gray-700">Daftar Pengadaan</h2>
            <p class="text-sm text-gray-500">Total: {{ count($pengadaan) }} pengadaan</p>
        </div>
        
        <div class="flex space-x-2">
            <a href="{{ route('pengadaan.create') }}" 
               class="flex items-center px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors text-sm">
                <i class="fas fa-plus mr-2"></i>
                Tambah Pengadaan
            </a>
        </div>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabel Pengadaan -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">#</th>
                    <th class="px-4 py-3 text-left font-semibold">ID</th>
                    <th class="px-4 py-3 text-left font-semibold">Vendor</th>
                    <th class="px-4 py-3 text-right font-semibold">Subtotal</th>
                    <th class="px-4 py-3 text-right font-semibold">PPN</th>
                    <th class="px-4 py-3 text-right font-semibold">Total</th>
                    <th class="px-4 py-3 text-left font-semibold">User</th>
                    <th class="px-4 py-3 text-center font-semibold">Status</th>
                    <th class="px-4 py-3 text-left font-semibold">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengadaan as $index => $p)
                    <tr class="border-t hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-gray-600">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-mono text-gray-600 text-sm">#{{ $p->idpengadaan }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $p->nama_vendor }}</div>
                        </td>
                        <td class="px-4 py-3 text-right font-mono text-gray-900">
                            Rp {{ number_format($p->subtotal_nilai, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-right font-mono text-gray-900">
                            Rp {{ number_format($p->ppn, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-right font-mono text-gray-900">
                            <strong>Rp {{ number_format($p->total_nilai, 0, ',', '.') }}</strong>
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ $p->nama_user }}</td>
                        <td class="px-4 py-3 text-center">
                            @php
                                // Konversi status angka ke teks
                                $statusText = $p->status == 1 ? 'AKTIF' : 'NONAKTIF';
                                $statusColor = $p->status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-sm">
                            {{ \Carbon\Carbon::parse($p->timestamp)->format('d M Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-2"></i>
                            <p>Belum ada data pengadaan</p>
                            <a href="{{ route('pengadaan.create') }}" class="text-orange-600 hover:underline mt-2 inline-block">
                                Buat pengadaan pertama
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Summary -->
    @if(count($pengadaan) > 0)
    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div class="text-center">
                <p class="text-gray-600">Total Pengadaan</p>
                <p class="text-lg font-bold text-gray-900">{{ count($pengadaan) }}</p>
            </div>
            <div class="text-center">
                <p class="text-gray-600">Total Nilai</p>
                <p class="text-lg font-bold text-green-600">
                    Rp {{ number_format(collect($pengadaan)->sum('total_nilai'), 0, ',', '.') }}
                </p>
            </div>
            <div class="text-center">
                <p class="text-gray-600">Rata-rata</p>
                <p class="text-lg font-bold text-blue-600">
                    Rp {{ number_format(collect($pengadaan)->avg('total_nilai'), 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection