<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengadaan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengadaanController extends Controller
{
    public function index()
    {
        try {
            $pengadaan = Pengadaan::getAll();
            return view('transaksi.pengadaan.index', compact('pengadaan'));
        } catch (\Exception $e) {
            Log::error('Error in PengadaanController index: ' . $e->getMessage());
            return view('transaksi.pengadaan.index', ['pengadaan' => []])
                ->with('error', 'Gagal memuat data pengadaan.');
        }
    }

    public function create()
    {
        try {
            $vendor = DB::select("SELECT idvendor, nama_vendor FROM vendor WHERE status = 1");
            return view('transaksi.pengadaan.create', compact('vendor'));
        } catch (\Exception $e) {
            Log::error('Error in PengadaanController create: ' . $e->getMessage());
            return redirect()->route('pengadaan.index')
                ->with('error', 'Gagal memuat form pengadaan.');
        }
    }

    public function store(Request $request)
    {
        try {
            // Debug: lihat data yang dikirim
            Log::info('Store Request Data:', $request->all());

            $request->validate([
                'vendor_id' => 'required|integer',
                'subtotal' => 'required|numeric|min:0',
                'ppn' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'status' => 'required|in:0,1',
            ]);

            $user_id = 1; // sementara fix dulu

            // Debug: lihat parameter yang akan dikirim ke SP
            Log::info('Calling SP with params:', [
                'user_id' => $user_id,
                'vendor_id' => $request->vendor_id,
                'subtotal' => $request->subtotal,
                'ppn' => $request->ppn,
                'total' => $request->total,
                'status' => $request->status
            ]);

            $idbaru = Pengadaan::createSP(
                $user_id,
                $request->vendor_id,
                $request->subtotal,
                $request->ppn,
                $request->total,
                $request->status
            );

            // Debug: lihat hasil dari SP
            Log::info('SP Result - ID Baru:', ['idbaru' => $idbaru]);

            if ($idbaru) {
                return redirect()->route('pengadaan.index')
                    ->with('success', "Pengadaan berhasil dibuat (ID: $idbaru)");
            } else {
                Log::error('SP returned null ID');
                return back()->with('error', 'Gagal membuat pengadaan. Stored procedure tidak mengembalikan ID.')
                    ->withInput();
            }

        } catch (\Exception $e) {
            Log::error('Error in PengadaanController store: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}