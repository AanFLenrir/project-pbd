@extends('layouts.app')

@section('title', 'Data Role')
@section('subtitle', 'Kelola peran pengguna dalam sistem.')

@section('content')
<div class="flex justify-between mb-4">
  <a href="{{ route('role.create') }}" 
     class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
    + Tambah Role
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
      <th class="px-4 py-2 text-left">Nama Role</th>
      <th class="px-4 py-2 text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($roles as $r)
      <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-2">{{ $r->idrole }}</td>
        <td class="px-4 py-2">{{ $r->nama_role }}</td>
        <td class="px-4 py-2 text-center">
          <a href="{{ route('role.edit', $r->idrole) }}" 
             class="text-blue-600 hover:underline">Edit</a>

          <form action="{{ route('role.destroy', $r->idrole) }}" 
                method="POST" 
                class="inline">
            @csrf @method('DELETE')
            <button onclick="return confirm('Yakin ingin menghapus role ini?')" 
                    class="text-red-500 hover:underline ml-2">
              Hapus
            </button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection