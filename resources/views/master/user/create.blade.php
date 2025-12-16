@extends('layouts.app')

@section('title', 'Tambah User')
@section('subtitle', 'Masukkan informasi pengguna baru.')

@section('content')
<form action="{{ route('user.store') }}" method="POST" class="space-y-4">
  @csrf
  <div>
    <label class="block text-gray-700 font-medium">Username</label>
    <input type="text" name="username" 
           class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200" 
           required>
  </div>

  <div>
    <label class="block text-gray-700 font-medium">Password</label>
    <input type="password" name="password" 
           class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200" 
           required>
  </div>

  <div>
    <label class="block text-gray-700 font-medium">Role</label>
    <select name="idrole" 
            class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200" 
            required>
      <option value="">-- Pilih Role --</option>
      @foreach ($roles as $r)
        <option value="{{ $r->idrole }}">{{ $r->nama_role }}</option>
      @endforeach
    </select>
  </div>

  <div class="flex justify-end gap-2">
    <a href="{{ route('user.index') }}" 
       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
  </div>
</form>
@endsection
