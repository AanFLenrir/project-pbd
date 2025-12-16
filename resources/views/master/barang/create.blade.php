@extends('layouts.app')

@section('title', 'Tambah Barang')
@section('subtitle', 'Masukkan data barang baru.')

@section('content')
<form action="{{ route('barang.store') }}" method="POST" class="space-y-4">
  @csrf

  <div>
    <label class="block text-gray-700 font-medium">Nama Barang</label>
    <input type="text" name="nama"
           class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200"
           required>
  </div>

  <div>
    <label class="block text-gray-700 font-medium">Jenis Barang</label>
    <input type="text" name="jenis"
           class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200"
           required>
  </div>

  <div>
    <label class="block text-gray-700 font-medium">Satuan</label>
    <select name="idsatuan" class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200" required>
      <option value="">-- Pilih Satuan --</option>
      @foreach ($satuan as $s)
        <option value="{{ $s->idsatuan }}">{{ $s->nama_satuan }}</option>
      @endforeach
    </select>
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
    <a href="{{ route('barang.index') }}"
       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
  </div>
</form>
@endsection