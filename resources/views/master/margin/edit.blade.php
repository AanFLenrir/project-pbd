@extends('layouts.app')

@section('title', 'Edit Margin Penjualan')
@section('subtitle', 'Perbarui data margin penjualan.')

@section('content')
<form action="{{ route('margin.update', $margin->idmargin_penjualan) }}" method="POST" class="space-y-4">
  @csrf @method('PUT')

  <div>
    <label class="block text-gray-700 font-medium">Persentase Margin (%)</label>
    <input type="number" step="0.01" name="persen"
           value="{{ $margin->persen }}"
           class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200"
           required>
  </div>

  <div>
    <label class="block text-gray-700 font-medium">Status</label>
    <select name="status"
            class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200">
      <option value="1" {{ $margin->status == '1' ? 'selected' : '' }}>Aktif</option>
      <option value="0" {{ $margin->status == '0' ? 'selected' : '' }}>Nonaktif</option>
    </select>
  </div>

  <div class="flex justify-end gap-2">
    <a href="{{ route('margin.index') }}"
       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
  </div>
</form>
@endsection