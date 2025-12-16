<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::getAll();
        return view('transaksi.penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $margin = DB::select("SELECT idmargin_penjualan, persen FROM margin_penjualan WHERE status = 1 ORDER BY idmargin_penjualan DESC");
        return view('transaksi.penjualan.create', compact('margin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subtotal' => 'required|numeric|min:0',
            'ppn' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'idmargin_penjualan' => 'required|integer',
        ]);

        $iduser = 1; // sementara manual, nanti bisa pakai Auth

        $idbaru = Penjualan::createSP(
            $request->subtotal,
            $request->ppn,
            $request->total,
            $iduser,
            $request->idmargin_penjualan
        );

        return redirect()->route('penjualan.index')
            ->with('success', "Penjualan berhasil dibuat (ID: $idbaru)");
    }
}