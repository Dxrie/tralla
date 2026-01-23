<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $borrows = Borrow::all();
        return view('users.peminjaman.index', compact('borrows'));
    }

    public function create()
    {
        return view('users.peminjaman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'divisi' => 'required',
            'foto_barang' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = $request->file('foto_barang')->store('barang', 'public');

        Borrow::create([
            'nama_barang' => $request->nama_barang,
            'divisi' => $request->divisi,
            'foto_barang' => $foto,
        ]);

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Barang berhasil dipinjam');
    }

    public function edit($id)
    {
        $borrow = Borrow::findOrFail($id);
        return view('users.peminjaman.edit', compact('borrow'));
    }

    public function update(Request $request, $id)
    {
        $borrow = Borrow::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'divisi' => 'required',
            'foto_barang' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto_barang')) {
            $foto = $request->file('foto_barang')->store('barang', 'public');
            $borrow->foto_barang = $foto;
        }

        $borrow->nama_barang = $request->nama_barang;
        $borrow->divisi = $request->divisi;
        $borrow->save();

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $borrow = Borrow::findOrFail($id);
        $borrow->delete();

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
