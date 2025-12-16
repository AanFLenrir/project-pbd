@extends('layouts.app_transaksi')

@section('title', 'Data Penerimaan')
@section('subtitle', 'Daftar semua transaksi penerimaan barang.')

@section('content')
<div class="flex justify-between mb-4">
  <a href="{{ route('penerimaan.create') }}"
     class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
    + Tambah Penerimaan
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
      <th class="px-4 py-2 text-left">ID Pengadaan</th>
      <th class="px-4 py-2 text-center">Nilai Pengadaan</th>
      <th class="px-4 py-2 text-center">User</th>
      <th class="px-4 py-2 text-center">Status</th>
      <th class="px-4 py-2 text-center">Tanggal</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($penerimaan as $p)
      <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-2">{{ $p->idpenerimaan }}</td>
        <td class="px-4 py-2">{{ $p->idpengadaan }}</td>
        <td class="px-4 py-2 text-center">Rp {{ number_format($p->nilai_pengadaan, 0, ',', '.') }}</td>
        <td class="px-4 py-2 text-center">{{ $p->nama_user }}</td>
        <td class="px-4 py-2 text-center">
          @if ($p->status == '1')
            <span class="text-green-600 font-medium">Aktif</span>
          @else
            <span class="text-gray-400">Nonaktif</span>
          @endif
        </td>
        <td class="px-4 py-2 text-center">{{ $p->created_at }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection