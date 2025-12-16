@extends('layouts.app')

@section('title', 'Data Margin Penjualan')
@section('subtitle', 'Kelola data margin keuntungan penjualan.')

@section('content')
<div class="flex justify-between mb-4">
  <a href="{{ route('margin.create') }}"
     class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
    + Tambah Margin
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
      <th class="px-4 py-2 text-center">Persentase (%)</th>
      <th class="px-4 py-2 text-center">Status</th>
      <th class="px-4 py-2 text-center">Dibuat</th>
      <th class="px-4 py-2 text-center">Diperbarui</th>
      <th class="px-4 py-2 text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($margin as $m)
      <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-2">{{ $m->idmargin_penjualan }}</td>
        <td class="px-4 py-2 text-center">{{ $m->persen }}%</td>
        <td class="px-4 py-2 text-center">
          @if ($m->status == '1')
            <span class="text-green-600 font-medium">Aktif</span>
          @else
            <span class="text-gray-400">Nonaktif</span>
          @endif
        </td>
        <td class="px-4 py-2 text-center">{{ $m->created_at ? $m->created_at->format('d/m/Y H:i') : '-' }}</td>
        <td class="px-4 py-2 text-center">{{ $m->updated_at ? $m->updated_at->format('d/m/Y H:i') : '-' }}</td>
        <td class="px-4 py-2 text-center">
          <a href="{{ route('margin.edit', $m->idmargin_penjualan) }}"
             class="text-blue-600 hover:underline">Edit</a>
          <form action="{{ route('margin.destroy', $m->idmargin_penjualan) }}"
                method="POST" class="inline">
            @csrf @method('DELETE')
            <button onclick="return confirm('Yakin ingin menghapus margin ini?')"
                    class="text-red-500 hover:underline ml-2">Hapus</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection