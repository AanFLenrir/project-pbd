@extends('layouts.app_transaksi')

@section('title', 'Tambah Pengadaan')
@section('subtitle', 'Masukkan data pengadaan baru (via Stored Procedure).')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    <!-- Flash Message -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pengadaan.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-2">Vendor</label>
            <select name="vendor_id"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-orange-200 focus:border-orange-500 @error('vendor_id') border-red-500 @enderror"
                    required>
                <option value="">-- Pilih Vendor --</option>
                @foreach ($vendor as $v)
                    <option value="{{ $v->idvendor }}" {{ old('vendor_id') == $v->idvendor ? 'selected' : '' }}>
                        {{ $v->nama_vendor }}
                    </option>
                @endforeach
            </select>
            @error('vendor_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Subtotal</label>
                <input type="number" name="subtotal" min="0" step="0.01"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-orange-200 focus:border-orange-500 @error('subtotal') border-red-500 @enderror"
                       value="{{ old('subtotal') }}"
                       required>
                @error('subtotal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">PPN</label>
                <input type="number" name="ppn" min="0" step="0.01"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-orange-200 focus:border-orange-500 @error('ppn') border-red-500 @enderror"
                       value="{{ old('ppn') }}"
                       required>
                @error('ppn')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Total</label>
                <input type="number" name="total" min="0" step="0.01"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-orange-200 focus:border-orange-500 @error('total') border-red-500 @enderror"
                       value="{{ old('total') }}"
                       required>
                @error('total')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Status</label>
            <select name="status"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-orange-200 focus:border-orange-500 @error('status') border-red-500 @enderror"
                    required>
                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('pengadaan.index') }}"
               class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
        </div>
    </form>
</div>
@endsection