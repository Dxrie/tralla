@extends('layouts.app')

@section('title', 'Tralla - Peminjaman Barang')

@section('content')
<div class="w-100 h-100 d-flex flex-column gap-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Data Equipment</h3>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary py-1.5" style="font-size: 0.75rem">Peminjaman Baru</a>
    </div>

    <div class="w-100 rounded-2 bg-white p-3">
        <table class="table table-hover mb-0" style="font-size:0.75rem;">
            <thead>
                <tr class="text-center">
                    <th style="width: 5%">No</th>
                    <th style="width: 25%" class="text-start">Nama Barang</th>
                    <th style="width: 30%" class="text-start">Foto Barang</th>
                    <th style="width: 25%">Divisi</th>
                    <th style="width: 15%">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($borrows as $borrow)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-start">{{ $borrow->nama_barang }}</td>
                        <td class="text-start">
                            <img 
                                src="{{ asset('storage/' . $borrow->foto_barang) }}" 
                                alt="Foto Barang" 
                                style="width: 100px; height: auto;"
                            >
                        </td>
                        <td>{{ $borrow->divisi }}</td>
                        <td>
                            <a href="{{ route('peminjaman.edit', $borrow->id) }}"
                                class="btn btn-outline-primary btn-sm px-2 py-1 me-1"
                                title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('peminjaman.destroy', $borrow->id) }}"
                                    method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-outline-danger btn-sm px-2 py-1"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                            <td colspan="5">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
