<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">@yield('title')</h1>
                    <p class="text-sm text-gray-600">@yield('subtitle')</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Tombol Kembali ke Modul Master Data -->
                    <a href="{{ route('barang.index') }}" 
                       class="flex items-center px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Master Data
                    </a>
                    <span class="text-sm text-gray-500">Modul Master Data</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Transaksi -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-8">
                <a href="{{ route('dashboard.transaksi') }}" 
                   class="flex items-center py-4 px-2 border-b-2 
                          @if(Route::currentRouteName() == 'dashboard.transaksi') border-orange-500 text-orange-600
                          @else border-transparent text-gray-500 hover:text-gray-700 @endif
                          font-medium text-sm">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('laporan.barang') }}" 
                   class="flex items-center py-4 px-2 border-b-2 
                          @if(Route::currentRouteName() == 'laporan.barang') border-orange-500 text-orange-600
                          @else border-transparent text-gray-500 hover:text-gray-700 @endif
                          font-medium text-sm">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Laporan Barang
                </a>

                <a href="{{ route('pengadaan.index') }}" 
                   class="flex items-center py-4 px-2 border-b-2 
                          @if(str_contains(Route::currentRouteName(), 'pengadaan')) border-orange-500 text-orange-600
                          @else border-transparent text-gray-500 hover:text-gray-700 @endif
                          font-medium text-sm">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Pengadaan
                </a>

                <a href="{{ route('penerimaan.index') }}" 
                   class="flex items-center py-4 px-2 border-b-2 
                          @if(str_contains(Route::currentRouteName(), 'penerimaan')) border-orange-500 text-orange-600
                          @else border-transparent text-gray-500 hover:text-gray-700 @endif
                          font-medium text-sm">
                    <i class="fas fa-truck-loading mr-2"></i>
                    Penerimaan
                </a>

                <a href="{{ route('penjualan.index') }}" 
                   class="flex items-center py-4 px-2 border-b-2 
                          @if(str_contains(Route::currentRouteName(), 'penjualan')) border-orange-500 text-orange-600
                          @else border-transparent text-gray-500 hover:text-gray-700 @endif
                          font-medium text-sm">
                    <i class="fas fa-cash-register mr-2"></i>
                    Penjualan
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-orange-100 border border-orange-400 text-orange-700 px-4 py-3 rounded mb-4">
                {{ session('warning') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-8">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Sistem Transaksi. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>