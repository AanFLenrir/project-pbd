<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LaporanBarangController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Cek apakah view laporan_barang_vu exists
            if (!$this->checkViewExists()) {
                return $this->handleViewNotExists();
            }

            $query = DB::table('laporan_barang_vu');

            // Apply filters jika ada
            $query = $this->applyFilters($query, $request);

            $laporanBarang = $query->orderBy('nama_barang')->get();
            $summary = $this->calculateSummary($laporanBarang);

            return view('transaksi.laporan_barang', compact('laporanBarang', 'summary'));

        } catch (\Exception $e) {
            Log::error('Error in LaporanBarangController index: ' . $e->getMessage());
            return $this->handleError($e->getMessage());
        }
    }

    public function filter(Request $request)
    {
        try {
            if (!$this->checkViewExists()) {
                return response()->json([
                    'error' => 'View laporan_barang_vu tidak tersedia'
                ], 404);
            }

            $query = DB::table('laporan_barang_vu');
            $query = $this->applyFilters($query, $request);

            $laporanBarang = $query->orderBy('nama_barang')->get();
            $summary = $this->calculateSummary($laporanBarang);

            // Return JSON untuk AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'laporanBarang' => $laporanBarang,
                    'summary' => $summary,
                    'total_data' => $laporanBarang->count()
                ]);
            }

            return view('transaksi.laporan_barang', compact('laporanBarang', 'summary'));

        } catch (\Exception $e) {
            Log::error('Error in LaporanBarangController filter: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Terjadi kesalahan saat memfilter data'
                ], 500);
            }
            
            return back()->with('error', 'Terjadi kesalahan saat memfilter data');
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            if (!$this->checkViewExists()) {
                return back()->with('error', 'View laporan_barang_vu tidak tersedia');
            }

            $query = DB::table('laporan_barang_vu');
            $query = $this->applyFilters($query, $request);

            $laporanBarang = $query->orderBy('nama_barang')->get();

            // Untuk sementara return view export sederhana
            return view('transaksi.export_laporan_barang', compact('laporanBarang'));

        } catch (\Exception $e) {
            Log::error('Error exporting data: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    /**
     * Check if view exists in database
     */
    private function checkViewExists(): bool
    {
        try {
            $viewExists = DB::select("
                SELECT COUNT(*) as count 
                FROM information_schema.views 
                WHERE table_schema = DATABASE() 
                AND table_name = 'laporan_barang_vu'
            ");
            
            return $viewExists[0]->count > 0;
        } catch (\Exception $e) {
            Log::error('Error checking view existence: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, Request $request)
    {
        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by status_stok
        if ($request->filled('status_stok')) {
            $query->where('status_stok', $request->status_stok);
        }

        // Search by nama_barang atau kode_barang
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'LIKE', "%{$search}%")
                  ->orWhere('kode_barang', 'LIKE', "%{$search}%")
                  ->orWhere('idbarang', 'LIKE', "%{$search}%");
            });
        }

        // Filter by stok range
        if ($request->filled('stok_min')) {
            $query->where('stok_sekarang', '>=', $request->stok_min);
        }

        if ($request->filled('stok_max')) {
            $query->where('stok_sekarang', '<=', $request->stok_max);
        }

        return $query;
    }

    /**
     * Calculate summary statistics from barang data
     */
    private function calculateSummary($laporanBarang): array
    {
        return [
            'total_barang' => $laporanBarang->count(),
            'total_nilai_stok' => $laporanBarang->sum('nilai_stok') ?? 0,
            'stok_aman' => $laporanBarang->where('status_stok', 'AMAN')->count(),
            'stok_menipis' => $laporanBarang->where('status_stok', 'STOK MENIPIS')->count(),
            'stok_habis' => $laporanBarang->where('status_stok', 'HABIS')->count(),
            'stok_kosong' => $laporanBarang->where('stok_sekarang', '<=', 0)->count(),
            'kategori_list' => $laporanBarang->pluck('kategori')->unique()->filter()->values(),
            'rata_rata_stok' => $laporanBarang->avg('stok_sekarang') ?? 0,
            'total_stok' => $laporanBarang->sum('stok_sekarang') ?? 0
        ];
    }

    /**
     * Handle case when view doesn't exist
     */
    private function handleViewNotExists()
    {
        // Create more comprehensive dummy data
        $laporanBarang = collect([
            (object)[
                'idbarang' => 1,
                'kode_barang' => 'BRG001',
                'nama_barang' => 'Laptop Dell XPS 13',
                'kategori' => 'Elektronik',
                'stok_sekarang' => 15,
                'stok_minimal' => 5,
                'stok_akhir' => 15,
                'status_stok' => 'AMAN',
                'nilai_stok' => 150000000
            ],
            (object)[
                'idbarang' => 2,
                'kode_barang' => 'BRG002',
                'nama_barang' => 'Mouse Wireless Logitech',
                'kategori' => 'Aksesori',
                'stok_sekarang' => 3,
                'stok_minimal' => 10,
                'stok_akhir' => 3,
                'status_stok' => 'STOK MENIPIS',
                'nilai_stok' => 450000
            ],
            (object)[
                'idbarang' => 3,
                'kode_barang' => 'BRG003',
                'nama_barang' => 'Keyboard Mechanical',
                'kategori' => 'Aksesori',
                'stok_sekarang' => 0,
                'stok_minimal' => 5,
                'stok_akhir' => 0,
                'status_stok' => 'HABIS',
                'nilai_stok' => 0
            ]
        ]);

        $summary = $this->calculateSummary($laporanBarang);
        
        return view('transaksi.laporan_barang', compact('laporanBarang', 'summary'))
            ->with('warning', 'View laporan_barang_vu belum tersedia di database. Menampilkan data contoh untuk demonstrasi.');
    }

    /**
     * Handle general errors
     */
    private function handleError($errorMessage)
    {
        $laporanBarang = collect();
        $summary = $this->calculateSummary($laporanBarang);
        
        return view('transaksi.laporan_barang', compact('laporanBarang', 'summary'))
            ->with('error', 'Terjadi kesalahan sistem: ' . $errorMessage);
    }

    /**
     * Get available categories for filter dropdown
     */
    public function getCategories()
    {
        try {
            if (!$this->checkViewExists()) {
                return response()->json([]);
            }

            $categories = DB::table('laporan_barang_vu')
                ->select('kategori')
                ->whereNotNull('kategori')
                ->distinct()
                ->orderBy('kategori')
                ->pluck('kategori');

            return response()->json($categories);

        } catch (\Exception $e) {
            Log::error('Error getting categories: ' . $e->getMessage());
            return response()->json([]);
        }
    }
}