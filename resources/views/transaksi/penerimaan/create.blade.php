@extends('layouts.app_transaksi')

@section('title', 'Tambah Penerimaan')
@section('subtitle', 'Catat penerimaan barang berdasarkan pengadaan.')

@section('content')
<form action="{{ route('penerimaan.store') }}" method="POST" class="space-y-4">
  @csrf

  <div>
    <label class="block text-gray-700 font-medium">Pengadaan</label>
    <select name="idpengadaan"
            class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200"
            required>
      <option value="">-- Pilih Pengadaan --</option>
      @foreach ($pengadaan as $p)
        <option value="{{ $p->idpengadaan }}">#{{ $p->idpengadaan }} - Rp {{ number_format($p->total_nilai, 0, ',', '.') }}</option>
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
    <a href="{{ route('penerimaan.index') }}"
       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
  </div>
</form>
@endsection