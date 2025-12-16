<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        $vendor = Vendor::all();
        return view('master.vendor.index', compact('vendor'));
    }

    public function create()
    {
        return view('master.vendor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_vendor' => 'required|string|max:100',
            'badan_hukum' => 'required|in:0,1',
            'status' => 'required|in:0,1'
        ]);

        Vendor::create($request->only('nama_vendor', 'badan_hukum', 'status'));
        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('master.vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_vendor' => 'required|string|max:100',
            'badan_hukum' => 'required|in:0,1',
            'status' => 'required|in:0,1'
        ]);

        $vendor = Vendor::findOrFail($id);
        $vendor->update($request->only('nama_vendor', 'badan_hukum', 'status'));

        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();
        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil dihapus!');
    }
}
