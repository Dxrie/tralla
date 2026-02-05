<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoanItemController extends Controller
{
    public function index()
    {
        $loans = Loan::with('loanItems')->latest()->get();
        return view('users.peminjaman.index', compact('loans'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required',
            'nama_barang' => 'required|array', // Must be an array
            'nama_barang.*' => 'required|string', // Each item must be a string
        ]);

        $loan = Loan::create([
            'nama_peminjam' => $request->nama_peminjam,
            'keterangan' => $request->keterangan,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'divisi' => $request->divisi,
        ]);

        foreach ($request->nama_barang as $barang) {
            $loan->loanItems()->create([
                'nama_barang' => $barang,
                // add other columns if needed
            ]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil disimpan');
    }
}
