@extends('layouts.app')

@section('title', 'Tralla - Peminjaman Barang')

@section('content')
<div class="w-100 h-100 d-flex flex-column gap-2" style="font-size:0.75rem;">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Peminjaman Barang</h4>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">+ Tambah Peminjaman</button>
    </div>
    {{-- Modal Add --}}
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="staticBackdropLabel">Tambah Peminjaman Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Modal Body --}}
                <div class="modal-body">
                    {{-- Error Message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger py-2" style="font-size:0.75rem">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- Form --}}
                    <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data" id="peminjamanForm" style="font-size:0.75rem">
                        @csrf
                        {{-- Barang & Foto --}}
                        <div class="mb-3 border rounded-2 p-3">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-7">
                                    <label class="form-label fw-semibold">Name</label>
                                    <input type="text" name="nama_barang" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold">Picture</label>
                                    <input type="file" name="foto_barang" class="form-control form-control-sm" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        {{-- Divisi --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Division</label>
                            <select name="divisi" class="form-select form-select-sm" required>
                                <option value="">-- Choose Division --</option>
                                <option value="KP">KP</option>
                                <option value="MBKM">MBKM</option>
                                <option value="Manajemen">Manajemen</option>
                                <option value="Magang PKL">Magang PKL</option>
                            </select>
                        </div>
                    </form>
                </div>
                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" form="peminjamanForm">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="formUbah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Form --}}
                <form method="POST" enctype="multipart/form-data" style="font-size: 0.75rem" id="ubahForm">
                    @csrf
                    @method('PUT')
                    {{-- Barang & Foto --}}
                    <div class="mb-3 border rounded p-3">
                        <div class="g-3 align-items-end">
                            <div class="col-md-7">
                                <label class="form-label fw-semibold">Name</label>
                                <input type="text" name="nama_barang" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Picture</label>
                                <img id="previewFoto" class="img-thumbnail mb-2" style="max-width:120px; display:none;">
                                <input type="file" name="foto_barang" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Division</label>
                        <select name="divisi" class="form-select form-select-sm">
                            <option value="">-- Choose Division --</option>
                            <option value="KP">KP</option>
                            <option value="MBKM">MBKM</option>
                            <option value="Manajemen">Manajemen</option>
                            <option value="Magang PKL">Magang PKL</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="ubahForm">Save</button>
            </div>
            </div>
        </div>
    </div>
    {{-- Table --}}
    <div class="w-100 rounded-2 bg-white p-3">
        <table class="table table-hover align-middle mb-0" style="font-size:0.75rem;">
            <thead class="table-light">
                <tr class="text-center">
                    <th style="width:5%">No</th>
                    <th style="width:25%" class="text-start">Nama Barang</th>
                    <th style="width:30%" class="text-start">Foto Barang</th>
                    <th style="width:25%">Divisi</th>
                    <th style="width:15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($borrows as $borrow)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-start">{{ $borrow->nama_barang }}</td>
                        <td class="text-start">
                            <img src="{{ asset('storage/' . $borrow->foto_barang) }}" alt="Foto Barang" class="img-thumbnail" style="max-width:100px;"></td>
                        <td>{{ $borrow->divisi }}</td>
                        <td>
                            {{-- Action --}}
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-outline-primary btn-sm btn-edit" data-id="{{ $borrow->id }}" data-nama="{{ $borrow->nama_barang }}" data-foto="{{ $borrow->foto_barang }}" data-divisi="{{ $borrow->divisi }}" data-bs-toggle="modal" data-bs-target="#formUbah">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('peminjaman.destroy', $borrow->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            Belum ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const editButtons = document.querySelectorAll('.btn-edit');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {

            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const foto = this.dataset.foto;
            const divisi = this.dataset.divisi;

            const form = document.getElementById('ubahForm');

            // set action form
            form.action = `/peminjaman/${id}`;

            // isi input
            form.querySelector('input[name="nama_barang"]').value = nama;
            form.querySelector('select[name="divisi"]').value = divisi;

            // preview foto lama
            const preview = document.getElementById('previewFoto');
            preview.src = `/storage/${foto}`;
            preview.style.display = 'block';
        });
    });

});
</script>
@endsection