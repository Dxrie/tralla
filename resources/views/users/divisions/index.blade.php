@extends('layouts.app')

@section('title', 'Divisi • Tralla')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 text-gray-800 mb-0">Manajemen Divisi</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-lg me-2"></i>Tambah Divisi
            </button>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Whoops!</strong> Ada masalah dengan input anda:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Table Card --}}
        <div class="card shadow border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center py-3" style="width: 5%;">No</th>
                                <th class="py-3">Nama Divisi</th>
                                <th class="text-end py-3 pe-4" style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($divisions as $division)
                                <tr>
                                    <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                    <td class="fw-medium">{{ $division->name }}</td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="{{ $division->id }}" data-name="{{ $division->name }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form method="POST" action="{{ route('divisi.destroy', $division) }}"
                                                onsubmit="return confirm('Hapus divisi ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="noDivision">
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <i class="bi bi-inbox fs-1 mb-3 text-secondary"></i>
                                            <p class="mb-0">Belum ada divisi yang dibuat.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="createModalLabel">Tambah Divisi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createForm" method="POST" action="{{ route('divisi.store') }}">
                    @csrf
                    <div class="modal-body pt-4">
                        <div class="mb-3">
                            <label for="createName" class="form-label text-muted small text-uppercase fw-bold">Nama
                                Divisi</label>
                            <input type="text" class="form-control form-control-lg" id="createName" name="name"
                                placeholder="Contoh: HR, Finance, Engineering" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button id="btnSave" type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="editModalLabel">Edit Divisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body pt-4">
                        <div class="mb-3">
                            <label for="editName" class="form-label text-muted small text-uppercase fw-bold">Nama
                                Divisi</label>
                            <input type="text" class="form-control form-control-lg" id="editName" name="name"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#createForm').on('submit', function(e) {
                    e.preventDefault();

                    const btn = $('#btnSave');
                    btn.prop('disabled', true).text('Loading...');

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        success: async function(response) {
                            const createModal = $('#createModal');
                            const modal = Modal.getOrCreateInstance(createModal);
                            modal.hide();

                            $('#createForm')[0].reset();

                            if ($('#noDivision').length) {
                                $('#noDivision').remove();
                            }

                            $('table tbody').append(response.html);

                            await Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Divisi telah ditambahkan.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr) {
                            btn.prop('disabled', false).text('Simpan');

                            let response = xhr.responseJSON;
                            let errorHtml = '';

                            if (xhr.status === 422 && response.errors) {
                                errorHtml = Object.values(response.errors)
                                    .map(error => `<li>${error}</li>`)
                                    .join('');
                                errorHtml = `<ul class="text-start mb-0">${errorHtml}</ul>`;
                            } else {
                                errorHtml = response.message || 'Terjadi kesalahan sistem.';
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Whoops!',
                                html: errorHtml,
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
