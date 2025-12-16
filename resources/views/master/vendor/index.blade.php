@extends('layouts.app')

@section('title', 'Data Vendor')
@section('subtitle', 'Kelola daftar vendor pemasok barang.')

@section('content')
<div class="flex justify-between mb-4">
  <a href="{{ route('vendor.create') }}"
     class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
    + Tambah Vendor
  </a>

  @if (session('success'))
    <div class="text-green-700 bg-green-100 px-4 py-2 rounded-lg shadow-sm">
      {{ session('success') }}
    </div>
  @endif
</div>

<table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
  <thead class="bg-gray-100 text-gray-700">
    <tr>
      <th class="px-4 py-2 text-left">#</th>
      <th class="px-4 py-2 text-left">Nama Vendor</th>
      <th class="px-4 py-2 text-center">Badan Hukum</th>
      <th class="px-4 py-2 text-center">Status</th>
      <th class="px-4 py-2 text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($vendor as $v)
      <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-2">{{ $v->idvendor }}</td>
        <td class="px-4 py-2">{{ $v->nama_vendor }}</td>
        <td class="px-4 py-2 text-center">
          @if ($v->badan_hukum == '1')
            <span class="text-green-600 font-medium">Ada</span>
          @else
            <span class="text-gray-500">Tidak Ada</span>
          @endif
        </td>
        <td class="px-4 py-2 text-center">
          @if ($v->status == '1')
            <span class="text-green-600 font-medium">Aktif</span>
          @else
            <span class="text-gray-400">Nonaktif</span>
          @endif
        </td>
        <td class="px-4 py-2 text-center">
          <a href="{{ route('vendor.edit', $v->idvendor) }}"
             class="text-blue-600 hover:underline">Edit</a>
          <form action="{{ route('vendor.destroy', $v->idvendor) }}"
                method="POST" class="inline">
            @csrf @method('DELETE')
            <button onclick="return confirm('Yakin ingin menghapus vendor ini?')"
                    class="text-red-500 hover:underline ml-2">Hapus</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection