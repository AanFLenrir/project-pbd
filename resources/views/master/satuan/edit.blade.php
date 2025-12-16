@extends('layouts.app')

@section('title', 'Edit Satuan')
@section('subtitle', 'Perbarui informasi satuan barang.')

@section('content')
<form action="{{ route('satuan.update', $satuan->idsatuan) }}" method="POST" class="space-y-4">
  @csrf @method('PUT')

  <div>
    <label class="block text-gray-700 font-medium">Nama Satuan</label>
    <input type="text" name="nama_satuan" 
           value="{{ $satuan->nama_satuan }}" 
           class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200" 
           required>
  </div>

  <div>
    <label class="block text-gray-700 font-medium">Status</label>
    <select name="status" 
            class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200">
      <option value="1" {{ $satuan->status == '1' ? 'selected' : '' }}>Aktif</option>
      <option value="0" {{ $satuan->status == '0' ? 'selected' : '' }}>Nonaktif</option>
    </select>
  </div>

  <div class="flex justify-end gap-2">
    <a href="{{ route('satuan.index') }}" 
       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
  </div>
</form>
@endsection