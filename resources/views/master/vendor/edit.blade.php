@extends('layouts.app')

@section('title', 'Edit Vendor')
@section('subtitle', 'Perbarui informasi vendor.')

@section('content')
<form action="{{ route('vendor.update', $vendor->idvendor) }}" method="POST" class="space-y-4">
  @csrf @method('PUT')

  <div>
    <label class="block text-gray-700 font-medium">Nama Vendor</label>
    <input type="text" name="nama_vendor"
           value="{{ $vendor->nama_vendor }}"
           class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200"
           required>
  </div>

  <div>
    <label class="block text-gray-700 font-medium">Badan Hukum</label>
    <select name="badan_hukum"
            class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200">
      <option value="1" {{ $vendor->badan_hukum == '1' ? 'selected' : '' }}>Ada</option>
      <option value="0" {{ $vendor->badan_hukum == '0' ? 'selected' : '' }}>Tidak Ada</option>
    </select>
  </div>

  <div>
    <label class="block text-gray-700 font-medium">Status</label>
    <select name="status"
            class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200">
      <option value="1" {{ $vendor->status == '1' ? 'selected' : '' }}>Aktif</option>
      <option value="0" {{ $vendor->status == '0' ? 'selected' : '' }}>Nonaktif</option>
    </select>
  </div>

  <div class="flex justify-end gap-2">
    <a href="{{ route('vendor.index') }}"
       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
  </div>
</form>
@endsection