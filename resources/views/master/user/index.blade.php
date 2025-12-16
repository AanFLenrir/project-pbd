@extends('layouts.app')

@section('title', 'Data User')
@section('subtitle', 'Kelola akun pengguna yang memiliki akses ke sistem.')

@section('content')
<div class="flex justify-between mb-4">
  <a href="{{ route('user.create') }}" 
     class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
    + Tambah User
  </a>

  @if (session('success'))
    <div class="text-green-700 bg-green-100 px-4 py-2 rounded-lg shadow-sm">
      {{ session('success') }}
    </div>
  @endif
</div>

<table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
  <thead class="bg-gray-100 text-gray-700">
    <tr>
      <th class="px-4 py-2 text-left">#</th>
      <th class="px-4 py-2 text-left">Username</th>
      <th class="px-4 py-2 text-left">Role</th>
      <th class="px-4 py-2 text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $u)
      <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-2">{{ $u->iduser }}</td>
        <td class="px-4 py-2">{{ $u->username }}</td>
        <td class="px-4 py-2">{{ $u->role->nama_role ?? '-' }}</td>
        <td class="px-4 py-2 text-center">
          <a href="{{ route('user.edit', $u->iduser) }}" 
             class="text-blue-600 hover:underline">Edit</a>
          <form action="{{ route('user.destroy', $u->iduser) }}" 
                method="POST" class="inline">
            @csrf @method('DELETE')
            <button onclick="return confirm('Yakin ingin menghapus user ini?')" 
                    class="text-red-500 hover:underline ml-2">Hapus</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
