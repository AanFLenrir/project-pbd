@extends('layouts.app')

@section('title', 'Tambah Margin Penjualan')
@section('subtitle', 'Masukkan margin keuntungan baru.')

@section('content')
<form action="{{ route('margin.store') }}" method="POST" class="space-y-4">
  @csrf

  <div>
    <label class="block text-gray-700 font-medium">Persentase Margin (%)</label>
    <input type="number" step="0.01" name="persen"
           class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200"
           required>
  </div>

  <div>
    <label class="block text-gray-700 font-medium">Status</label>
    <select name="status"
            class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200">
      <option value="1">Aktif</option>
      <option value="0">Nonaktif</option>
    </select>
  </div>

  <div class="flex justify-end gap-2">
    <a href="{{ route('margin.index') }}"
       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
  </div>
</form>
@endsection