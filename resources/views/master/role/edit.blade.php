@extends('layouts.app')

@section('title', 'Edit Role')
@section('subtitle', 'Perbarui informasi peran pengguna.')

@section('content')
<form action="{{ route('role.update', $role->idrole) }}" method="POST" class="space-y-4">
  @csrf @method('PUT')

  <div>
    <label class="block text-gray-700 font-medium">Nama Role</label>
    <input type="text" name="nama_role" 
           value="{{ $role->nama_role }}" 
           class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200" 
           required>
  </div>

  <div class="flex justify-end gap-2">
    <a href="{{ route('role.index') }}" 
       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
  </div>
</form>
@endsection
