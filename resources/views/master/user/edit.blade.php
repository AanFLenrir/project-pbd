@extends('layouts.app')

@section('title', 'Edit User')
@section('subtitle', 'Perbarui informasi akun pengguna.')

@section('content')
<form action="{{ route('user.update', $user->iduser) }}" method="POST" class="space-y-4">
  @csrf @method('PUT')

  <div>
    <label class="block text-gray-700 font-medium">Username</label>
    <input type="text" name="username" 
           value="{{ $user->username }}" 
           class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200" 
           required>
  </div>

  <div>
    <label class="block text-gray-700 font-medium">Password (kosongkan jika tidak diganti)</label>
    <input type="password" name="password" 
           class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200">
  </div>

  <div>
    <label class="block text-gray-700 font-medium">Role</label>
    <select name="idrole" 
            class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring focus:ring-blue-200" 
            required>
      @foreach ($roles as $r)
        <option value="{{ $r->idrole }}" {{ $user->idrole == $r->idrole ? 'selected' : '' }}>
          {{ $r->nama_role }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="flex justify-end gap-2">
    <a href="{{ route('user.index') }}" 
       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
  </div>
</form>
@endsection
