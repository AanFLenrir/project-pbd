<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('master.role.index', compact('roles'));
    }

    public function create()
    {
        return view('master.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|string|max:100'
        ]);

        Role::create($request->only('nama_role'));
        return redirect()->route('role.index')->with('success', 'Role berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('master.role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->only('nama_role'));
        return redirect()->route('role.index')->with('success', 'Role berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('role.index')->with('success', 'Role berhasil dihapus!');
    }
}
