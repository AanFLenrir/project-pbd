<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Satuan;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('satuan')->get();
        return view('master.barang.index', compact('barang'));
    }

    public function create()
    {
        $satuan = Satuan::where('status', 1)->get();
        return view('master.barang.create', compact('satuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jenis' => 'required|string|max:50',
            'idsatuan' => 'required|exists:satuan,idsatuan',
            'status' => 'required|in:0,1'
        ]);

        Barang::create($request->only('nama', 'jenis', 'idsatuan', 'status'));
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $satuan = Satuan::where('status', 1)->get();
        return view('master.barang.edit', compact('barang', 'satuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jenis' => 'required|string|max:50',
            'idsatuan' => 'required|exists:satuan,idsatuan',
            'status' => 'required|in:0,1'
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->only('nama', 'jenis', 'idsatuan', 'status'));

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }
}
