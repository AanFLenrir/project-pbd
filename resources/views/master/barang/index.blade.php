@extends('layouts.app')

@section('title', 'Data Barang')
@section('subtitle', 'Kelola daftar barang yang tersedia di sistem.')

@section('content')
<div class="flex justify-between mb-4">
  {{-- Tombol Tambah Barang --}}
  <a href="{{ route('barang.create') }}"
     class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
    + Tambah Barang
  </a>

  {{-- Notifikasi Berhasil --}}
  @if (session('success'))
    <div class="text-green-700 bg-green-100 px-4 py-2 rounded-lg shadow-sm">
      {{ session('success') }}
    </div>
  @endif
</div>

{{-- Table Data Barang --}}
<div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-sm">
  <table class="min-w-full">
    <thead class="bg-gray-100 text-gray-700">
      <tr>
        <th class="px-4 py-2 text-left">#</th>
        <th class="px-4 py-2 text-left">Nama Barang</th>
        <th class="px-4 py-2 text-left">Jenis</th>
        <th class="px-4 py-2 text-center">Satuan</th>
        <th class="px-4 py-2 text-center">Status</th>
        <th class="px-4 py-2 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($barang as $b)
        <tr class="border-t hover:bg-gray-50">
          <td class="px-4 py-2">{{ $b->idbarang }}</td>
          <td class="px-4 py-2">{{ $b->nama }}</td>
          <td class="px-4 py-2">{{ $b->jenis }}</td>
          <td class="px-4 py-2 text-center">{{ $b->satuan->nama_satuan ?? '-' }}</td>
          <td class="px-4 py-2 text-center">
            @if ($b->status == 1)
              <span class="text-green-600 font-medium">Aktif</span>
            @else
              <span class="text-gray-500">Nonaktif</span>
            @endif
          </td>
          <td class="px-4 py-2 text-center">
            {{-- Tombol Edit --}}
            <a href="{{ route('barang.edit', $b->idbarang) }}"
               class="text-blue-600 hover:underline">Edit</a>

            {{-- Tombol Hapus --}}
            <form action="{{ route('barang.destroy', $b->idbarang) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit"
                      onclick="return confirm('Yakin ingin menghapus barang ini?')"
                      class="text-red-500 hover:underline ml-2">
                Hapus
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data barang.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
