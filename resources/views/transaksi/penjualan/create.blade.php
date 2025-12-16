@extends('layouts.app_transaksi')

@section('title', 'Tambah Penjualan')
@section('subtitle', 'Catat transaksi penjualan barang.')

@section('content')
<form action="{{ route('penjualan.store') }}" method="POST" class="space-y-4">
  @csrf

  <div class="grid grid-cols-3 gap-4">
    <div>
      <label class="block text-gray-700 font-medium">Subtotal</label>
      <input type="number" name="subtotal" min="0"
             class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200"
             required>
    </div>

    <div>
      <label class="block text-gray-700 font-medium">PPN</label>
      <input type="number" name="ppn" min="0"
             class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200"
             required>
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Total</label>
      <input type="number" name="total" min="0"
             class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200"
             required>
    </div>
  </div>

  <div>
    <label class="block text-gray-700 font-medium">Margin Penjualan</label>
    <select name="idmargin_penjualan"
            class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200"
            required>
      <option value="">-- Pilih Margin --</option>
      @foreach ($margin as $m)
        <option value="{{ $m->idmargin_penjualan }}">{{ $m->persen }}%</option>
      @endforeach
    </select>
  </div>

  <div class="flex justify-end gap-2">
    <a href="{{ route('penjualan.index') }}"
       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
  </div>
</form>
@endsection