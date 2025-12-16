@extends('layouts.app_transaksi')

@section('title', 'Data Penjualan')
@section('subtitle', 'Daftar semua transaksi penjualan.')

@section('content')
<div class="flex justify-between mb-4">
  <a href="{{ route('penjualan.create') }}"
     class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
    + Tambah Penjualan
  </a>

  @if (session('success'))
    <div class="text-green-700 bg-green-100 px-4 py-2 rounded-lg shadow-sm">
      {{ session('success') }}
    </div>
  @endif
</div>

<table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm text-sm">
  <thead class="bg-gray-100 text-gray-700">
    <tr>
      <th class="px-4 py-2 text-left">#</th>
      <th class="px-4 py-2 text-center">Subtotal</th>
      <th class="px-4 py-2 text-center">PPN</th>
      <th class="px-4 py-2 text-center">Total</th>
      <th class="px-4 py-2 text-center">Margin (%)</th>
      <th class="px-4 py-2 text-center">User</th>
      <th class="px-4 py-2 text-center">Tanggal</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($penjualan as $p)
      <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-2">{{ $p->idpenjualan }}</td>
        <td class="px-4 py-2 text-center">Rp {{ number_format($p->subtotal_nilai, 0, ',', '.') }}</td>
        <td class="px-4 py-2 text-center">Rp {{ number_format($p->ppn, 0, ',', '.') }}</td>
        <td class="px-4 py-2 text-center font-semibold">Rp {{ number_format($p->total_nilai, 0, ',', '.') }}</td>
        <td class="px-4 py-2 text-center">{{ $p->persen_margin }}%</td>
        <td class="px-4 py-2 text-center">{{ $p->nama_user }}</td>
        <td class="px-4 py-2 text-center">{{ $p->created_at }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection