@extends('layouts.app')

@section('title', 'Tambah Role')
@section('subtitle', 'Masukkan peran pengguna baru ke sistem.')

@section('content')
<form action="{{ route('role.store') }}" method="POST" class="space-y-4">
  @csrf
  <div>
    <label class="block text-gray-700 font-medium">Nama Role</label>
    <input type="text" name="nama_role" 
           class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200" 
           required>
  </div>

  <div class="flex justify-end gap-2">
    <a href="{{ route('role.index') }}" 
       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
  </div>
</form>
@endsection
