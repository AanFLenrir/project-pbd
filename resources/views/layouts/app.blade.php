<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title') - Master Data | Sistem Inventory</title>

  {{-- Tailwind via CDN -> aman tanpa Vite --}}
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  {{-- NAVBAR MASTER DATA --}}
  <nav class="bg-blue-600 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <span class="text-2xl font-bold tracking-tight">Master Data</span>
        <span class="bg-white/20 text-xs px-2 py-1 rounded">Inventory App</span>
      </div>

      <div class="space-x-4 font-medium">
        @if (Route::has('role.index'))
          <a href="{{ route('role.index') }}" class="{{ Request::is('role*') ? 'underline font-bold' : '' }} hover:underline">Role</a>
        @endif

        @if (Route::has('user.index'))
          <a href="{{ route('user.index') }}" class="{{ Request::is('user*') ? 'underline font-bold' : '' }} hover:underline">User</a>
        @endif

        @if (Route::has('satuan.index'))
          <a href="{{ route('satuan.index') }}" class="{{ Request::is('satuan*') ? 'underline font-bold' : '' }} hover:underline">Satuan</a>
        @endif

        @if (Route::has('vendor.index'))
          <a href="{{ route('vendor.index') }}" class="{{ Request::is('vendor*') ? 'underline font-bold' : '' }} hover:underline">Vendor</a>
        @endif

        @if (Route::has('barang.index'))
          <a href="{{ route('barang.index') }}" class="{{ Request::is('barang*') ? 'underline font-bold' : '' }} hover:underline">Barang</a>
        @endif

        @if (Route::has('margin.index'))
          <a href="{{ route('margin.index') }}" class="{{ Request::is('margin*') ? 'underline font-bold' : '' }} hover:underline">Margin</a>
        @endif
      </div>
    </div>
  </nav>

  {{-- KONTEN UTAMA --}}
  <main class="max-w-7xl mx-auto p-6">
    <div class="mb-4 flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
        <p class="text-gray-500">@yield('subtitle')</p>
      </div>

      {{-- shortcut to transaksi (opsional, tampilkan hanya jika route ada) --}}
      <div>
        @if (Route::has('pengadaan.index'))
          <a href="{{ route('pengadaan.index') }}" class="bg-orange-500 text-white px-3 py-1 rounded hover:bg-orange-600 text-sm">
            Modul Transaksi →
          </a>
        @endif
      </div>
    </div>

    {{-- Isi halaman --}}
    <div>
      @yield('content')
    </div>
  </main>

  <footer class="text-center text-sm text-gray-500 py-4 mt-8 border-t">
    Sistem Inventory © {{ date('Y') }} - Modul Master Data
  </footer>
</body>
</html>