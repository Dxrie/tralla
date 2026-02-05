@extends('layouts.app')

@section('title', 'Tralla - Peminjaman Barang')

@section('content')
<div class="w-100 h-100 d-flex flex-column gap-2" style="font-size:0.75rem;">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Peminjaman Barang</h4>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreate">Tambah Peminjaman</button>
    </div>

    {{-- Modal Create --}}
    <div class="modal fade" id="modalCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createBackdropLabel">Tambah Peminjaman</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('peminjaman.store') }}" method="POST" id="formCreate">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="create_nama_peminjam">Nama Peminjam</label>
                            <input type="text" name="nama_peminjam" class="form-control form-control-sm" id="create_nama_peminjam" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="create_keterangan">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control form-control-sm" id="create_keterangan" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_nama_barang" class="form-label fw-semibold">Nama Barang</label>
                            <div id="barang-container">
                                <div class="d-flex flex-row mb-2 barang-row gap-2">
                                    <input type="text" name="nama_barang[]" id="create_nama_barang" class="form-control form-control-sm">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-barang"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                            <button type="button" id="add-barang" class="btn btn-primary btn-sm">Tambah Barang</button>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="create_tanggal_pinjam">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" class="form-control form-control-sm" id="create_tanggal_pinjam" required>
                        </div>
                        <div class="mb-3">
                            <label for="create-divisi" class="form-label fw-semibold">Divisi</label>
                            <select name="divisi" id="create_divisi" class="form-control form-control-sm">
                                <option value="">--divisi--</option>
                                <option value="karyawan">karyawan</option>
                                <option value="magang">magang</option>
                                <option value="admin">admin</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" form="formCreate">Create</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update -->
    <div class="modal fade" id="modalUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="formUpdate">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="update_nama_peminjam">Nama Peminjam</label>
                            <input type="text" name="nama_peminjam" class="form-control form-control-sm" id="update_nama_peminjam" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="update_keterangan">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control form-control-sm" id="update_keterangan" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_nama_barang" class="form-label fw-semibold">Daftar Barang</label>
                            <div id="update-barang-container"></div>
                            <button type="button" id="update-add-barang" class="btn btn-primary btn-sm">Tambah Barang</button>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="update_tanggal_pinjam">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" class="form-control form-control-sm" id="update_tanggal_pinjam" required>
                        </div>
                        <div class="mb-3">
                            <label for="update-divisi" class="form-label fw-semibold">Divisi</label>
                            <select name="divisi" id="update_divisi" class="form-control form-control-sm">
                                <option value="">--divisi--</option>
                                <option value="karyawan">karyawan</option>
                                <option value="magang">magang</option>
                                <option value="admin">admin</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="formUpdate">Update</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal View --}}
    <div class="modal fade" id="modalView" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p><strong>Peminjam:</strong> <span id="view-nama"></span></p>
                        <hr>
                        <h6>Daftar Barang:</h6>
                        <ul id="items-list" class="list-group"></ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Back</button>
                </div>
            </div>
        </div>
    </div>

    {{-- {{ dd($loans) }} --}}
    {{-- Table --}}
    <div class="w-100 rounded-2 bg-white p-3">
        <table class="table table-hover align-middle mb-0" style="font-size:0.75rem;">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Keterangan</th>
                    <th>Tanggal Pinjam</th>
                    <th>Divisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($loans as $loan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $loan->nama_peminjam }}</td>
                        <td>{{ $loan->keterangan }}</td>
                        <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d-m-Y') }}</td>
                        <td>{{ $loan->divisi }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                {{-- Button View --}}
                                <button type="button" class="btn btn-outline-warning btn-sm btn-view" data-bs-toggle="modal" data-bs-target="#modalView" data-peminjam="{{ $loan->nama_peminjam }}" data-items='@json($loan->loanItems)'>
                                    <i class="bi bi-eye-fill"></i>
                                </button>

                                {{-- Button Update --}}
                                <button type="button" class="btn btn-outline-primary btn-sm btn-update" data-bs-toggle="modal" data-bs-target="#modalUpdate" data-id="{{ $loan->id }}" data-nama="{{ $loan->nama_peminjam }}" data-keterangan="{{ $loan->keterangan }}" data-tanggal="{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('Y-m-d') }}" data-divisi="{{ $loan->divisi }}" data-items='@json($loan->loanItems)'><i class="bi bi-pencil-square"></i></button>

                                {{-- Button Delete --}}
                                <form action="{{ route('peminjaman.destroy', $loan->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus peminjaman ini?')" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
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
    const updateContainer = document.getElementById('update-barang-container');
    const createContainer = document.getElementById('barang-container');

    // Function to generate a row (Reusable)
    function createBarangRow(container, value = '') {
        const newRow = document.createElement('div');
        newRow.className = 'd-flex flex-row mb-2 barang-row gap-2';
        newRow.innerHTML = `
            <input type="text" name="nama_barang[]" class="form-control form-control-sm" value="${value}" required>
            <button type="button" class="btn btn-outline-danger btn-sm remove-barang">
                <i class="bi bi-trash"></i>
            </button>
        `;
        container.appendChild(newRow);
    }

    // Logic for Update Modal
    const editButtons = document.querySelectorAll('.btn-update');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Target the FORM inside the modal
            const form = document.getElementById('formUpdate'); 
            form.action = `/peminjaman/${this.dataset.id}`;

            // Fill basic inputs
            form.querySelector('#update_nama_peminjam').value = this.dataset.nama;
            form.querySelector('#update_keterangan').value = this.dataset.keterangan;
            form.querySelector('#update_tanggal_pinjam').value = this.dataset.tanggal;
            form.querySelector('#update_divisi').value = this.dataset.divisi;

            // Fill Editable Items
            updateContainer.innerHTML = ''; 
            const items = JSON.parse(this.dataset.items);
            
            if (items && items.length > 0) {
                items.forEach(item => {
                    createBarangRow(updateContainer, item.nama_barang);
                });
            } else {
                createBarangRow(updateContainer);
            }
        });
    });

    // Add new row logic
    document.getElementById('update-add-barang').addEventListener('click', () => createBarangRow(updateContainer));
    document.getElementById('add-barang').addEventListener('click', () => createBarangRow(createContainer));

    // Improved Delete Delegation (Handles icon clicks)
    document.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.remove-barang');
        if (deleteBtn) {
            const container = deleteBtn.closest('#barang-container, #update-barang-container');
            if (container.querySelectorAll('.barang-row').length > 1) {
                deleteBtn.closest('.barang-row').remove();
            } else {
                alert('Minimal harus ada satu barang.');
            }
        }
    });

    // View Modal Logic
    const viewButtons = document.querySelectorAll('.btn-view');
    viewButtons.forEach(button => {
        button.addEventListener('click', function () {
            const items = JSON.parse(this.dataset.items);
            document.getElementById('view-nama').innerText = this.dataset.peminjam;
            const listContainer = document.getElementById('items-list');
            listContainer.innerHTML = '';

            if (items && items.length > 0) {
                items.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = item.nama_barang;
                    listContainer.appendChild(li);
                });
            } else {
                listContainer.innerHTML = '<li class="list-group-item text-muted">Tidak ada barang.</li>';
            }
        });
    });
});
</script>
@endsection