<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardTransaksiController extends Controller
{
    public function index()
    {
        try {
            // Data statistik utama untuk dashboard
            $stats = $this->getDashboardStats();
            
            // Data untuk charts
            $chartData = $this->getChartData();
            
            // Data aktivitas terbaru
            $recentActivities = $this->getRecentActivities();
            
            // Data barang stok menipis
            $lowStockItems = $this->getLowStockItems();

            return view('transaksi.dashboard', compact(
                'stats', 
                'chartData', 
                'recentActivities', 
                'lowStockItems'
            ));

        } catch (\Exception $e) {
            Log::error('Error in DashboardTransaksiController: ' . $e->getMessage());
            
            // Return view dengan data kosong jika error
            return $this->handleErrorView();
        }
    }

    /**
     * Get main dashboard statistics
     */
    private function getDashboardStats()
    {
        // Cek jika view laporan_dashboard_vu exists
        $viewExists = DB::select("
            SELECT COUNT(*) as count 
            FROM information_schema.views 
            WHERE table_schema = DATABASE() 
            AND table_name = 'laporan_dashboard_vu'
        ");

        if ($viewExists[0]->count > 0) {
            // Gunakan data dari view jika ada
            $laporan = DB::table('laporan_dashboard_vu')->first();
            
            return [
                'total_barang' => DB::table('barang')->count(),
                'total_vendor' => DB::table('vendor')->count(),
                'stok_menipis' => DB::table('barang')->whereRaw('stok_sekarang <= stok_minimal')->count(),
                'total_penjualan' => $laporan->total_pendapatan ?? 0,
                'total_margin' => $laporan->total_margin ?? 0,
                'total_transaksi' => $laporan->total_transaksi ?? 0,
                'transaksi_hari_ini' => $laporan->transaksi_hari_ini ?? 0,
                'rata_rata_transaksi' => $laporan->rata_rata_transaksi ?? 0,
                'produk_terlaris' => $laporan->produk_terlaris ?? 'Tidak ada data',
                'kategori_populer' => $laporan->kategori_populer ?? 'Tidak ada data',
                'persentase_margin' => $laporan->persentase_margin ?? 0
            ];
        }

        // Fallback: hitung manual jika view tidak ada
        return $this->calculateStatsManually();
    }

    /**
     * Calculate stats manually if view doesn't exist
     */
    private function calculateStatsManually()
    {
        $totalPenjualan = DB::table('penjualan')
            ->where('status', 'LUNAS')
            ->sum('total_nilai') ?? 0;

        $totalHPP = DB::table('penjualan as p')
            ->join('penjualan_detail as pd', 'p.idpenjualan', '=', 'pd.idpenjualan')
            ->join('barang as b', 'pd.idbarang', '=', 'b.idbarang')
            ->where('p.status', 'LUNAS')
            ->sum(DB::raw('pd.qty * b.hpp')) ?? 0;

        $totalMargin = $totalPenjualan - $totalHPP;
        $persentaseMargin = $totalPenjualan > 0 ? ($totalMargin / $totalPenjualan) * 100 : 0;

        return [
            'total_barang' => DB::table('barang')->count(),
            'total_vendor' => DB::table('vendor')->count(),
            'stok_menipis' => DB::table('barang')->whereRaw('stok_sekarang <= stok_minimal')->count(),
            'total_penjualan' => $totalPenjualan,
            'total_margin' => $totalMargin,
            'total_transaksi' => DB::table('penjualan')->where('status', 'LUNAS')->count(),
            'transaksi_hari_ini' => DB::table('penjualan')
                ->whereDate('tanggal', today())
                ->where('status', 'LUNAS')
                ->count(),
            'rata_rata_transaksi' => DB::table('penjualan')
                ->where('status', 'LUNAS')
                ->avg('total_nilai') ?? 0,
            'produk_terlaris' => $this->getBestSellingProduct(),
            'kategori_populer' => $this->getPopularCategory(),
            'persentase_margin' => $persentaseMargin
        ];
    }

    /**
     * Get best selling product
     */
    private function getBestSellingProduct()
    {
        $produk = DB::table('penjualan_detail as pd')
            ->join('barang as b', 'pd.idbarang', '=', 'b.idbarang')
            ->join('penjualan as p', 'pd.idpenjualan', '=', 'p.idpenjualan')
            ->where('p.status', 'LUNAS')
            ->select('b.nama_barang', DB::raw('SUM(pd.qty) as total_terjual'))
            ->groupBy('b.idbarang', 'b.nama_barang')
            ->orderByDesc('total_terjual')
            ->first();

        return $produk ? $produk->nama_barang . ' (' . $produk->total_terjual . ' pcs)' : 'Tidak ada data';
    }

    /**
     * Get popular category
     */
    private function getPopularCategory()
    {
        $kategori = DB::table('penjualan_detail as pd')
            ->join('barang as b', 'pd.idbarang', '=', 'b.idbarang')
            ->join('penjualan as p', 'pd.idpenjualan', '=', 'p.idpenjualan')
            ->where('p.status', 'LUNAS')
            ->select('b.kategori', DB::raw('SUM(pd.qty) as total_terjual'))
            ->groupBy('b.kategori')
            ->orderByDesc('total_terjual')
            ->first();

        return $kategori ? $kategori->kategori : 'Tidak ada data';
    }

    /**
     * Get data for charts
     */
    private function getChartData()
    {
        // Transaksi per bulan (6 bulan terakhir)
        $transaksiPerBulan = DB::table('penjualan')
            ->select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('MONTHNAME(tanggal) as nama_bulan'),
                DB::raw('YEAR(tanggal) as tahun'),
                DB::raw('COUNT(*) as total')
            )
            ->where('status', 'LUNAS')
            ->where('tanggal', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('bulan', 'nama_bulan', 'tahun')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Pendapatan per bulan (6 bulan terakhir)
        $pendapatanPerBulan = DB::table('penjualan')
            ->select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('MONTHNAME(tanggal) as nama_bulan'),
                DB::raw('YEAR(tanggal) as tahun'),
                DB::raw('SUM(total_nilai) as total')
            )
            ->where('status', 'LUNAS')
            ->where('tanggal', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('bulan', 'nama_bulan', 'tahun')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        return [
            'transaksi_per_bulan' => $transaksiPerBulan,
            'pendapatan_per_bulan' => $pendapatanPerBulan
        ];
    }

    /**
     * Get recent activities
     */
    private function getRecentActivities()
    {
        // Gabungkan aktivitas dari pengadaan, penerimaan, dan penjualan
        $pengadaan = DB::table('pengadaan')
            ->select(
                'idpengadaan as id',
                'no_pengadaan as nomor',
                'tanggal_pengadaan as tanggal',
                'status',
                DB::raw("'PENGADAAN' as tipe"),
                DB::raw("'fas fa-shopping-cart' as icon")
            )
            ->whereDate('created_at', '>=', now()->subDays(7));

        $penerimaan = DB::table('penerimaan')
            ->select(
                'idpenerimaan as id',
                'no_penerimaan as nomor',
                'tanggal_penerimaan as tanggal',
                'status',
                DB::raw("'PENERIMAAN' as tipe"),
                DB::raw("'fas fa-truck-loading' as icon")
            )
            ->whereDate('created_at', '>=', now()->subDays(7));

        $penjualan = DB::table('penjualan')
            ->select(
                'idpenjualan as id',
                'no_penjualan as nomor',
                'tanggal as tanggal',
                'status',
                DB::raw("'PENJUALAN' as tipe"),
                DB::raw("'fas fa-cash-register' as icon")
            )
            ->whereDate('created_at', '>=', now()->subDays(7));

        return $pengadaan->union($penerimaan)
            ->union($penjualan)
            ->orderBy('tanggal', 'desc')
            ->limit(8)
            ->get();
    }

    /**
     * Get low stock items
     */
    private function getLowStockItems()
    {
        return DB::table('barang')
            ->select('idbarang', 'nama_barang', 'stok_sekarang', 'stok_minimal')
            ->whereRaw('stok_sekarang <= stok_minimal')
            ->orderBy('stok_sekarang', 'asc')
            ->limit(6)
            ->get();
    }

    /**
     * API untuk data real-time (AJAX)
     */
    public function getDataRealTime()
    {
        try {
            $data = [
                'transaksi_hari_ini' => DB::table('penjualan')
                    ->whereDate('tanggal', today())
                    ->where('status', 'LUNAS')
                    ->count(),
                'pendapatan_hari_ini' => DB::table('penjualan')
                    ->whereDate('tanggal', today())
                    ->where('status', 'LUNAS')
                    ->sum('total_nilai') ?? 0,
                'stok_menipis' => DB::table('barang')
                    ->whereRaw('stok_sekarang <= stok_minimal')
                    ->count(),
                'total_pengadaan' => DB::table('pengadaan')
                    ->where('status', 'DISETUJUI')
                    ->whereDate('created_at', today())
                    ->count(),
                'timestamp' => now()->format('H:i:s')
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getDataRealTime: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'data' => [
                    'transaksi_hari_ini' => 0,
                    'pendapatan_hari_ini' => 0,
                    'stok_menipis' => 0,
                    'total_pengadaan' => 0,
                    'timestamp' => now()->format('H:i:s')
                ]
            ]);
        }
    }

    /**
     * Handle error view
     */
    private function handleErrorView()
    {
        $stats = [
            'total_barang' => 0,
            'total_vendor' => 0,
            'stok_menipis' => 0,
            'total_penjualan' => 0,
            'total_margin' => 0,
            'total_transaksi' => 0,
            'transaksi_hari_ini' => 0,
            'rata_rata_transaksi' => 0,
            'produk_terlaris' => 'Error loading data',
            'kategori_populer' => 'Error loading data',
            'persentase_margin' => 0
        ];

        $chartData = ['transaksi_per_bulan' => collect(), 'pendapatan_per_bulan' => collect()];
        $recentActivities = collect();
        $lowStockItems = collect();

        return view('transaksi.dashboard', compact(
            'stats', 
            'chartData', 
            'recentActivities', 
            'lowStockItems'
        ))->with('error', 'Terjadi kesalahan saat memuat data dashboard.');
    }
}