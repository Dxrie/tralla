<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{
    public function index()
    {
        // Adding with('loanItems') ensures the "View" button has data to show
        $loans = Loan::with('loanItems')->latest()->get();
        return view('users.peminjaman.index', compact('loans'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_pinjam' => 'required|date',
            'divisi' => 'required|in:karyawan,magang,admin',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string',
        ]);

        $loan = Loan::create([
            'nama_peminjam' => $request->nama_peminjam,
            'keterangan' => $request->keterangan,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'divisi' => $request->divisi,
        ]);

        foreach ($request->nama_barang as $item_name) {
            if (!empty($item_name)) {
                $loan->loanItems()->create([
                    'nama_barang' => $item_name,
                ]);
            }
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dibuat');
    }

    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'nama_peminjam' => 'required|string',
            'keterangan' => 'nullable|string',
            'tanggal_pinjam' => 'required|date',
            'divisi' => 'required|in:karyawan,magang,admin',
            'nama_barang' => 'required|array|min:1',
            'nama_barang.*' => 'required|string',
        ]);

        // Use a transaction to ensure data integrity
        DB::transaction(function () use ($request, $loan) {
            // 1. Update the main Loan record
            $loan->update([
                'nama_peminjam' => $request->nama_peminjam,
                'keterangan' => $request->keterangan,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'divisi' => $request->divisi,
            ]);

            // 2. Delete all existing items for this loan
            $loan->loanItems()->delete();

            // 3. Re-insert the items from the request
            foreach ($request->nama_barang as $item) {
                if (!empty($item)) {
                    $loan->loanItems()->create([
                        'nama_barang' => $item
                    ]);
                }
            }
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui');
    }
    
    public function destroy(Loan $loan)
    {
        DB::transaction(function () use ($loan) {
            // Delete items first to maintain integrity
            $loan->loanItems()->delete();
            
            // Then delete the loan
            $loan->delete();
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus');
    }
}
