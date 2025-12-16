<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarginPenjualan;

class MarginPenjualanController extends Controller
{
    public function index()
    {
        $margin = MarginPenjualan::all();
        return view('master.margin.index', compact('margin'));
    }

    public function create()
    {
        return view('master.margin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'persen' => 'required|numeric|min:0',
            'status' => 'required|in:0,1'
        ]);

        MarginPenjualan::create($request->only('persen', 'status'));
        return redirect()->route('margin.index')->with('success', 'Margin berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $margin = MarginPenjualan::findOrFail($id);
        return view('master.margin.edit', compact('margin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'persen' => 'required|numeric|min:0',
            'status' => 'required|in:0,1'
        ]);

        $margin = MarginPenjualan::findOrFail($id);
        $margin->update($request->only('persen', 'status'));

        return redirect()->route('margin.index')->with('success', 'Margin berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $margin = MarginPenjualan::findOrFail($id);
        $margin->delete();
        return redirect()->route('margin.index')->with('success', 'Margin berhasil dihapus!');
    }
}
