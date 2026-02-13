@extends('layouts.app')

@section('title', 'Divisi • Tralla')

@section('content')
    <style>
        .modal-dialog-scrollable .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .dashed-border {
            border-style: dashed;
            border-width: 1px;
            border-color: #ced4da;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }
    </style>

    <div class="container-fluid py-4">
        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="h4 text-gray-800 mb-0">Manajemen Divisi</h2>
                <button type="button" class="btn btn-primary" id="btn-open-create">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Divisi
                </button>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Search and Filter --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <form method="GET" class="row g-2 align-items-end">
                    <div class="col-12 col-md-6">
                        <label class="form-label mb-1">Cari divisi</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Cari nama divisi...">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label mb-1">Per halaman</label>
                        <select name="per_page" class="form-select">
                            <option value="10" @selected(request('per_page', 10) == 10)>10</option>
                            <option value="25" @selected(request('per_page', 10) == 25)>25</option>
                            <option value="50" @selected(request('per_page', 10) == 50)>50</option>
                            <option value="100" @selected(request('per_page', 10) == 100)>100</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-2"></i>Cari
                        </button>
                    </div>
                    <div class="col-6 col-md-2">
                        <a href="{{ route('divisi.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="card shadow border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="divisions-table">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center py-3" style="width: 5%;">No</th>
                                <th class="py-3">Nama Divisi</th>
                                <th class="text-end py-3 pe-4" style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($divisions as $division)
                                <tr id="division-{{ $division->id }}">
                                    <td class="text-center text-muted">{{ ($divisions->firstItem() ?? 0) + $loop->index }}</td>
                                    <td class="fw-medium">{{ $division->name }}</td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="{{ $division->id }}" data-name="{{ $division->name }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form method="POST" action="{{ route('divisi.destroy', $division) }}"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger btn-delete-static"
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

        {{-- Pagination --}}
        @if($divisions->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $divisions->links() }}
            </div>
        @endif
    </div>

    {{-- Create Modal (Dynamic) --}}
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="createModalLabel">Tambah Divisi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createForm" method="POST" action="{{ route('divisi.store') }}">
                    @csrf
                    <div class="modal-body pt-4">
                        {{-- Container for Dynamic Rows --}}
                        <div id="division-fields-container"></div>

                        {{-- Add More Button --}}
                        <div class="d-grid gap-2">
                            <button type="button" id="add-more-btn" class="btn btn-outline-primary border-dashed">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Baris
                            </button>
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

    {{-- Hidden Template for New Rows --}}
    <div id="division-row-template" class="d-none">
        <div class="division-row dashed-border position-relative">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary">Data Divisi</span>
                <button type="button" class="btn-close remove-row-btn small" aria-label="Close"></button>
            </div>

            <div class="form-group">
                <label class="form-label small text-muted text-uppercase fw-bold">Nama Divisi</label>
                <input type="text" class="form-control" name="divisions[INDEX][name]" placeholder="Contoh: HR, Finance"
                    required>
                <div class="invalid-feedback"></div>
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

                function resetRowNumbers() {
                    const rows = $('#divisions-table tbody tr').not('#noDivision');
                    rows.each(function(index) {
                        $(this).find('td:first').text(index + 1);
                    });
                }

                const $container = $('#division-fields-container');
                const $template = $('#division-row-template');

                function addRow() {
                    let newIndex = $('.division-row').length;
                    let $newRow = $template.children().clone();

                    $newRow.find('input').each(function() {
                        let oldName = $(this).attr('name');
                        if (oldName) {
                            $(this).attr('name', oldName.replace('INDEX', newIndex));
                        }
                        $(this).val('').removeClass('is-invalid');
                    });

                    $container.append($newRow);

                    $('.modal-body').animate({
                        scrollTop: $('.modal-body').prop("scrollHeight")
                    }, 500);
                }

                $('#btn-open-create').on('click', function() {
                    $container.html('');
                    addRow();
                    const modal = new bootstrap.Modal(document.getElementById('createModal'));
                    modal.show();
                });

                $('#add-more-btn').on('click', function() {
                    addRow();
                });

                $(document).on('click', '.remove-row-btn', function() {
                    if ($('.division-row').length > 1) {
                        $(this).closest('.division-row').fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        Swal.fire('Info', 'Minimal satu data divisi diperlukan.', 'info');
                    }
                });

                $('#createForm').on('submit', function(e) {
                    e.preventDefault();
                    const btn = $('#btnSave');
                    const originalText = btn.html();

                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').text('');

                    btn.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        success: async function(response) {
                            const createModal = $('#createModal');
                            const modal = bootstrap.Modal.getInstance(createModal);
                            modal.hide();

                            $('#createForm')[0].reset();
                            $container.html('');

                            if ($('#noDivision').length) {
                                $('#noDivision').remove();
                            }

                            $('table tbody').append(response.html);

                            resetRowNumbers();

                            await Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr) {
                            btn.prop('disabled', false).html(originalText);

                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validasi Gagal',
                                    text: 'Periksa inputan berwarna merah.'
                                });

                                $.each(errors, function(key, messages) {
                                    let parts = key.split('.');
                                    let inputName = `divisions[${parts[1]}][${parts[2]}]`;
                                    let $input = $(`[name="${inputName}"]`);

                                    if ($input.length > 0) {
                                        $input.addClass('is-invalid');
                                        $input.next('.invalid-feedback').text(messages[0]);
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Whoops!',
                                    text: xhr.responseJSON?.message ||
                                        'Terjadi kesalahan sistem.'
                                });
                            }
                        },
                        complete: function() {
                            btn.prop('disabled', false).html(originalText);
                        }
                    });
                });

                $('#editForm').on('submit', function(e) {
                    e.preventDefault();
                    const form = $(this);
                    const id = form.data('id');
                    const url = form.attr('action');
                    const btn = form.find('button[type="submit"]');

                    btn.prop('disabled', true).text('Updating...');

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: form.serialize(),
                        success: async function(response) {
                            const modal = bootstrap.Modal.getInstance($('#editModal'));
                            modal.hide();

                            $(`#division-${id}`).replaceWith(response.html);

                            await Swal.fire({
                                icon: 'success',
                                title: 'Diperbarui!',
                                text: 'Data divisi berhasil diupdate.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            btn.prop('disabled', false).text('Update');
                        },
                        error: function(xhr) {
                            btn.prop('disabled', false).text('Update');
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: xhr.responseJSON?.message
                            });
                        }
                    });
                });

                $('#editModal').on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget);
                    const id = button.data('id');
                    const name = button.data('name');
                    const modal = $(this);

                    modal.find('#editName').val(name);
                    modal.find('#editForm').attr('action', `/dashboard/divisi/${id}`);
                    modal.find('#editForm').data('id', id);
                });

                // Event Delegation
                $(document).on('submit', '.delete-form', function(e) {
                    e.preventDefault();
                    const form = $(this);
                    const url = form.attr('action');
                    const row = form.closest('tr');

                    Swal.fire({
                        title: 'Hapus Divisi?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: form.serialize(),
                                success: function(response) {
                                    row.fadeOut(300, function() {
                                        $(this).remove();

                                        resetRowNumbers();

                                        if ($('#divisions-table tbody tr')
                                            .length === 0) {
                                            $('table tbody').html(`
                                <tr id="noDivision">
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <i class="bi bi-inbox fs-1 mb-3 text-secondary"></i>
                                            <p class="mb-0">Belum ada divisi yang dibuat.</p>
                                        </div>
                                    </td>
                                </tr>
                            `);
                                        }
                                    });

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Terhapus!',
                                        text: response.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: 'Terjadi kesalahan saat menghapus data.'
                                    });
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
