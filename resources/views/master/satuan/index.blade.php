@extends('layouts.app')

@section('title', 'Data Satuan')
@section('subtitle', 'Kelola satuan barang yang tersedia di sistem.')

@section('content')
<div class="flex justify-between mb-4">
  <a href="{{ route('satuan.create') }}" 
     class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
    + Tambah Satuan
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
      <th class="px-4 py-2 text-left">Nama Satuan</th>
      <th class="px-4 py-2 text-center">Status</th>
      <th class="px-4 py-2 text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($satuan as $s)
      <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-2">{{ $s->idsatuan }}</td>
        <td class="px-4 py-2">{{ $s->nama_satuan }}</td>
        <td class="px-4 py-2 text-center">
          @if ($s->status == '1')
            <span class="text-green-600 font-medium">Aktif</span>
          @else
            <span class="text-gray-400">Nonaktif</span>
          @endif
        </td>
        <td class="px-4 py-2 text-center">
          <a href="{{ route('satuan.edit', $s->idsatuan) }}" 
             class="text-blue-600 hover:underline">Edit</a>
          <form action="{{ route('satuan.destroy', $s->idsatuan) }}" method="POST" class="inline">
            @csrf @method('DELETE')
            <button onclick="return confirm('Yakin ingin menghapus satuan ini?')" 
                    class="text-red-500 hover:underline ml-2">Hapus</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection