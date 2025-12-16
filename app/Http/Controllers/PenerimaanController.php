<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerimaan;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    public function index()
    {
        $penerimaan = Penerimaan::getAll();
        return view('transaksi.penerimaan.index', compact('penerimaan'));
    }

    public function create()
    {
        $pengadaan = DB::select("SELECT idpengadaan, total_nilai FROM pengadaan WHERE status = 1 ORDER BY idpengadaan DESC");
        return view('transaksi.penerimaan.create', compact('pengadaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idpengadaan' => 'required|integer',
            'status' => 'required|in:0,1',
        ]);

        $iduser = 1; // sementara fix manual (nanti bisa dari Auth)

        $idbaru = Penerimaan::createSP(
            $request->idpengadaan,
            $iduser,
            $request->status
        );

        return redirect()->route('penerimaan.index')
            ->with('success', "Penerimaan berhasil dibuat (ID: $idbaru)");
    }
}
