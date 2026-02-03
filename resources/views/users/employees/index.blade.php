@extends('layouts.app')

@section('title', 'Karyawan • Tralla')

@section('content')
    <style>
        .modal-dialog-scrollable .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .dashed-border {
            border-style: dashed;
        }
    </style>

    <div class="container-fluid py-4">

        {{-- Header & Add Button --}}
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="h4 text-gray-800">Manajemen Karyawan</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                    <i class="bi bi-person-plus-fill me-2"></i>Tambah Karyawan
                </button>
            </div>
        </div>

        {{-- Filter & Search Card --}}
        <div class="card shadow border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('karyawan.index') }}">
                    <div class="row g-3">
                        {{-- Search Input --}}
                        <div class="col-md-6 col-lg-5">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0 ps-0"
                                    placeholder="Cari nama atau email..." value="{{ request('search') }}">
                            </div>
                        </div>

                        {{-- Role Filter --}}
                        <div class="col-md-4 col-lg-3">
                            <select name="role" class="form-select">
                                <option value="">Semua Role</option>
                                <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>Employee
                                </option>
                                <option value="employer" {{ request('role') == 'employer' ? 'selected' : '' }}>Employer
                                </option>
                            </select>
                        </div>

                        {{-- Actions --}}
                        <div class="col-md-2 col-lg-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Filter
                            </button>
                            @if (request()->has('search') || request()->has('role'))
                                <a href="{{ route('karyawan.index') }}" class="btn btn-outline-secondary">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="card shadow border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="employees-table">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Divisi</th>
                                <th>Role</th>
                                <th>Bergabung</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee)
                                @include('users.employees.partials.row', ['employee' => $employee])
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Tidak ada data karyawan ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('users.employees.partials.modals')

    <script type="module">
        $(document).ready(function() {
            const $container = $('#employee-fields-container');
            const $template = $('#employee-row-template');

            const routes = {
                update: "{{ route('karyawan.update', ':id') }}",
                destroy: "{{ route('karyawan.destroy', ':id') }}"
            };

            // Add Dynamic Rows
            $('#add-more-btn').on('click', function() {
                let newIndex = $('.employee-row').length;
                let $newRow = $template.children().clone();

                $newRow.find('input, select').each(function() {
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
            });

            // Remove Row (Create Modal)
            $(document).on('click', '.remove-row-btn', function() {
                if ($('.employee-row').length > 1) {
                    $(this).closest('.employee-row').fadeOut(300, function() {
                        $(this).remove();
                    });
                } else {
                    Swal.fire('Info', 'Minimal satu data karyawan diperlukan.', 'info');
                }
            });

            // Store Submission
            $('#createEmployeeForm').on('submit', function(e) {
                e.preventDefault();
                let $form = $(this);
                let $btn = $('#btn-save');
                let originalBtnText = $btn.html();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('karyawan.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#addEmployeeModal [data-bs-dismiss="modal"]').trigger('click');
                        $form[0].reset();
                        $container.html('');
                        $('#add-more-btn').click();

                        // Prepend new data
                        $('#employees-table tbody').prepend(response.html);

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        handleValidationErrors(xhr, $btn, originalBtnText);
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });

            // Open Edit Modal & Populate Data
            $(document).on('click', '.btn-edit', function() {
                let data = $(this).data('json');

                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_email').val(data.email);
                $('#edit_division_id').val(data.division_id ?? '');
                $('#edit_role').val(data.role);
                $('#edit_password').val('');

                $('#editEmployeeForm .is-invalid').removeClass('is-invalid');

                let modalEl = document.getElementById('editEmployeeModal');
                let modal = Modal.getOrCreateInstance(modalEl);
                modal.show();
            });

            // Update Submission
            $('#editEmployeeForm').on('submit', function(e) {
                e.preventDefault();

                let id = $('#edit_id').val();
                let $btn = $('#btn-update');
                let originalBtnText = $btn.html();
                let url = routes.update.replace(':id', id);

                $btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span> Updating...');

                $.ajax({
                    url: url,
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        let modalEl = document.getElementById('editEmployeeModal');
                        let modal = Modal.getInstance(modalEl);
                        modal.hide();

                        // Replace the row
                        $(`#employee-row-${id}`).replaceWith(response.html);

                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, messages) {
                                let $input = $(`#edit_${key}`);
                                if ($input.length > 0) {
                                    $input.addClass('is-invalid');
                                    $input.next('.invalid-feedback').text(messages[0]);
                                }
                            });
                            Swal.fire('Validasi Gagal', 'Periksa inputan anda.', 'error');
                        } else {
                            Swal.fire('Error', 'Gagal update data.', 'error');
                        }
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });

            $(document).on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let url = routes.destroy.replace(':id', id);
                let $row = $(`#employee-row-${id}`);

                Swal.fire({
                    title: 'Hapus Karyawan?',
                    text: `Anda yakin ingin menghapus "${name}"?`,
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
                            type: "POST",
                            data: {
                                _method: 'DELETE',
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                $row.fadeOut(300, function() {
                                    $(this).remove();
                                });
                                Swal.fire('Terhapus!', response.message, 'success');
                            },
                            error: function(xhr) {
                                Swal.fire('Error', 'Gagal menghapus data.', 'error');
                            }
                        });
                    }
                });
            });

            // Helper for Create Validation
            function handleValidationErrors(xhr, $btn, originalBtnText) {
                $btn.prop('disabled', false).html(originalBtnText);
                if (xhr.status === 422) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: 'Periksa inputan berwarna merah.'
                    });
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        let parts = key.split('.');
                        let inputName = `employees[${parts[1]}][${parts[2]}]`;
                        let $input = $(`[name="${inputName}"]`);
                        if ($input.length > 0) {
                            $input.addClass('is-invalid');
                            $input.next('.invalid-feedback').text(messages[0]);
                        }
                    });
                } else {
                    Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
                }
            }
        });
    </script>
@endsection
