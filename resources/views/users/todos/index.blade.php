@extends('layouts.app')

@section('title', 'Daftar To-Do • Tralla')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="w-100 h-100 d-flex flex-column gap-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="fw-bold text-center mb-0">To-Do List</h3>
        <button id='openModalBtn' type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#todoModal">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah To-Do</span>
        </button>
    </div>

    {{-- Filter --}}
    <div class="w-100 rounded-2 bg-white p-3">
        <form method="GET" class="filter-form row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <label class="form-label mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Cari title todo...">
            </div>

            <div class="col-6 col-md-2">
                <label class="form-label mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-6 col-md-2">
                <label class="form-label mb-1">Bulan</label>
                <select name="bulan" class="form-select">
                    <option value="">Semua</option>
                    @foreach ($months as $num => $name)
                        <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-2">
                <label class="form-label mb-1">Tahun</label>
                <select name="tahun" class="form-select">
                    <option value="">Semua</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-2">
                <label class="form-label mb-1 text-wrap">Absensi/Halaman</label>
                <select name="per_page" class="form-select">
                    @foreach ([5, 10, 25, 50] as $pp)
                        <option value="{{ $pp }}" @selected((int) request('per_page', 10) === $pp)>{{ $pp }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary" id="filterBtn">
                    <i class="spinner-border spinner-border-sm d-none" id="filterSpinner"></i>
                    <span>Filter</span>
                </button>
                <button type="button" id="filterResetBtn" class="btn btn-outline-secondary">
                    Reset
                </button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="w-100 rounded-2 bg-white p-3">
        <div class="table-responsive">
            <table class="table table-hover mb-0" style="font-size:0.925rem;">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%;">ID</th>
                        <th style="width: 15%;" class="text-start">Title</th>
                        <th style="width: 20%;" class="text-start">Description</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Starting Date</th>
                        <th style="width: 15%;">Finish Date</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>

                <tbody id="todoTableBody">
                    @forelse ($todos as $index => $todo)
                        @include('users.todos.partials.table_row', ['todo' => $todo, 'index' => $index + 1])
                    @empty
                        <tr class="text-center">
                            <td colspan="7">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3" id="paginationContainer">
                {{ $todos->appends(request()->query())->links() }}
        </div>
    </div>
</div>

{{-- Form Modal --}}
@include('users.todos.partials.form-modal')

{{-- View Modal --}}
@include('users.todos.partials.view-modal')

<style>
.modal-dialog-scrollable .modal-body {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}

.truncate-cell {
    display: block;
    max-width: 100%;
    overflow: hidden;

    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    word-break: break-word;
}
</style>

@push('scripts')
<script type="module">
const todoRoutes = {
    store: '{{ route("todo.store") }}',
    update: '{{ route("todo.update", ":id") }}',
    destroy: '{{ route("todo.destroy", ":id") }}'
};

$(function() {
    const $form      = $('#todoForm');
    const $inputs    = $form.find('input:not([name="_method"]), select, textarea');
    const $submitBtn = $form.find('button[type="submit"]');
    const $buttons   = $form.find('button[type="button"]:not(.btn-close)');
    const $spinner   = $('#submitSpinner');
    const $wrapper   = $('#subtasksWrapper');
    const $addBtn    = $('#addSubtaskBtn');

    $addBtn.on('click', function () {
        $wrapper.append(`
            <div class="subtask-item d-flex gap-2 mb-2">
                <input type="text"
                    name="subtasks[]"
                    class="form-control form-control-sm"
                    placeholder="Subtask name">
                <button type="button"
                    class="btn btn-outline-danger btn-sm remove-subtask">
                    &times;
                </button>
            </div>
        `);

        $wrapper.parent()[0].scrollTop = $wrapper.parent()[0].scrollHeight;
    });

    $wrapper.on('click', '.remove-subtask', function () {
        $(this).closest('.subtask-item').remove();
    });

    $('[data-bs-dismiss="modal"]').on('click', function() {
        $form[0].reset();
        $wrapper.empty();

        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.invalid-feedback').remove();

        $inputs.prop('disabled', false);
        $submitBtn.prop('disabled', false);
        $buttons.prop('disabled', false);
        $spinner.addClass('d-none');
    });

    $('#openModalBtn').on('click', function () {
        $form[0].reset();
        $wrapper.empty();

        $form.attr('action', '{{ route("todo.store") }}');
        $('#formMethod').val('POST');
        $('#todoId').val('');

        $('#todoModalTitle').text('New To-Do');
        $('#submitBtnText').text('Simpan');
    });

    // FORM SUBMIT
    $form.on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        $spinner.removeClass('d-none');
        $inputs.prop('disabled', true);
        $submitBtn.prop('disabled', true);
        $buttons.prop('disabled', true);

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,

            success: function (res) {
                $('.btn-close').trigger('click');

                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: res.message,
                    timer: 3000,
                });

                // Refresh the table
                $('.filter-form').trigger('submit');
            },

            error: function (xhr) {
                $inputs.prop('disabled', false);
                $submitBtn.prop('disabled', false);
                $buttons.prop('disabled', false);
                $spinner.addClass('d-none');

                Swal.fire(
                    'Error!',
                    'Something went wrong.',
                    'error'
                );

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    // clear old errors
                    $form.find('.is-invalid').removeClass('is-invalid');
                    $form.find('.invalid-feedback').remove();

                    $.each(errors, function (field, messages) {
                        const $input = $form.find(`[name="${field}"], [name="${field}[]"]`).first();
                        $input.addClass('is-invalid');
                        $input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                    });
                }
            }
        });
    });

    // FILTER SUBMIT
    $('.filter-form').on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('ajax', '1');

        $('#filterBtn').prop('disabled', true);
        $('#filterResetBtn').prop('disabled', true);
        $('#filterBtn').find('#filterSpinner').removeClass('d-none');

        $.ajax({
            url: '{{ route("todo.index") }}',
            method: 'GET',
            data: $(this).serialize(),
            success: function (res) {
                $('#todoTableBody').html(res.html);
                $('#paginationContainer').html(res.pagination);
            },
            error: function (xhr) {
                Swal.fire(
                    'Error!',
                    'Something went wrong.',
                    'error'
                );
            },
            complete: function () {
                $('#filterBtn').prop('disabled', false);
                $('#filterResetBtn').prop('disabled', false);
                $('#filterBtn').find('#filterSpinner').addClass('d-none');
            }
        });
    });

    // FILTER RESET
    $('#filterResetBtn').on('click', function (e) {
        e.preventDefault();
        $('.filter-form')[0].reset();
        $('.filter-form').trigger('submit');
    });

    // PAGINATION
    $(document).on('click', '#paginationContainer a', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');

        $.ajax({
            url: url,
            method: 'GET',
            data: { ajax: '1' },
            success: function (res) {
                $('#todoTableBody').html(res.html);
                $('#paginationContainer').html(res.pagination);
            },
            error: function (xhr) {
                Swal.fire(
                    'Error!',
                    'Something went wrong.',
                    'error'
                );
            }
        });
    });

    // EDIT MODE TODO FORM
    $('tbody').on('click', '.editTodoBtn', function () {
        const data = $(this).data();

        $form.attr('action', todoRoutes.update.replace(':id', data.id));
        $('#formMethod').val('PUT');
        $('#todoId').val(data.id);

        $('#todoForm input[name="title"]').val(data.title);
        $('#todoForm input[name="description"]').val(data.description);
        $('#todoForm select[name="status"]').val(data.status);
        $('#todoForm input[name="start_date"]').val(data.start_date);
        $('#todoForm input[name="finish_date"]').val(data.finish_date);

        $wrapper.empty();

        if (data.subtasks) {
            data.subtasks.forEach(name => {
                $wrapper.append(`
                    <div class="subtask-item d-flex gap-2 mb-2">
                        <input type="text" name="subtasks[]" class="form-control form-control-sm" value="${name}">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-subtask">&times;</button>
                    </div>
                `);
            });
        }

        $('#todoModalTitle').text('Edit To-Do');
        $('#submitBtnText').text('Update');
    });

    // DELETE TODO (AJAX)
    $('tbody').on('click', '.deleteTodoBtn', function () {
        const todoId = $(this).data('id');
        const title = $(this).data('title');
        const $row = $(this).closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            text: `Are you sure to delete "${title}"? You won't be able to revert this!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait while we delete the .',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: todoRoutes.destroy.replace(':id', todoId),
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        Swal.close();

                        Swal.fire(
                            'Deleted!',
                            'Your todo has been deleted.',
                            'success'
                        );

                        // Refresh the table
                        $('.filter-form').trigger('submit');
                    },
                    error: function (xhr) {
                        Swal.close();
                        
                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    // VIEW TODO MODAL
    $('tbody').on('click', '.viewTodoBtn', function () {
        const data = $(this).data();

        $('#viewTitle').text(data.title);
        $('#viewDescription').text(data.description || '-');
        $('#viewStartDate').text(data.start_date);
        $('#viewFinishDate').text(data.finish_date);

        // Status cycling
        const statuses = ['On Progress', 'Hold', 'Done'];
        let currentStatusIndex = statuses.indexOf(data.status);
        let originalStatus = data.status;
        $('#currentStatus').text(data.status);
        $('#statusValue').val(data.status);
        $('#todoIdForStatus').val(data.id);

        $('#prevStatusBtn').off('click').on('click', function () {
            currentStatusIndex = (currentStatusIndex - 1 + statuses.length) % statuses.length;
            updateStatus(statuses[currentStatusIndex], data.id, originalStatus);
        });

        $('#nextStatusBtn').off('click').on('click', function () {
            currentStatusIndex = (currentStatusIndex + 1) % statuses.length;
            updateStatus(statuses[currentStatusIndex], data.id, originalStatus);
        });

        // Subtasks
        const $subtasksContainer = $('#viewSubtasks');
        $subtasksContainer.empty();
        if (data.subtasks && data.subtasks.length > 0) {
            data.subtasks.forEach(subtask => {
                $subtasksContainer.append(`
                    <div class="d-flex align-items-center gap-3 mb-2 p-2 rounded-2 border">
                        <input class="form-check-input view-subtask-checkbox mt-0" type="checkbox" data-subtask-id="${subtask.id}" ${subtask.is_done ? 'checked' : ''}>
                        <span class="fw-medium ${subtask.is_done ? 'text-decoration-line-through text-muted' : ''}">${subtask.name}</span>
                    </div>
                `);
            });
        } else {
            $subtasksContainer.append(`<div class="text-center py-4">
                    <i class="bi bi-inbox-fill text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">No items found</p>
                </div>`);
        }
    });

    // TOGGLE SUBTASK IN VIEW MODAL (AJAX)
    $('#viewModal').on('change', '.view-subtask-checkbox', function () {
        const subtaskId = $(this).data('subtask-id');
        const $checkbox = $(this);
        const $span = $checkbox.siblings('span');

        // Show loading Swal
        Swal.fire({
            title: 'Updating...',
            text: 'Please wait while we update the subtask.',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: `/todo/subtask/${subtaskId}/toggle`,
            method: 'PATCH',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                Swal.close();

                $checkbox.prop('checked', res.is_done);

                if (res.is_done) {
                    $span.addClass('text-decoration-line-through text-muted');
                } else {
                    $span.removeClass('text-decoration-line-through text-muted');
                }

                Swal.fire(
                    'Success',
                    'This subtask has now been marked done!',
                    'success'
                );

                // Refresh the table
                $('.filter-form').trigger('submit');
            },
            error: function (xhr) {
                Swal.close();

                // Revert checkbox on error
                $checkbox.prop('checked', !$checkbox.prop('checked'));
                Swal.fire(
                    'Error!',
                    'Something went wrong.',
                    'error'
                );
            }
        });
    });

    function updateStatus(newStatus, todoId, originalStatus) {
        const $statusSpan = $('#currentStatus');
        $statusSpan.addClass('fade-out');

        setTimeout(() => {
            $statusSpan.text(newStatus).removeClass('fade-out').addClass('fade-in');
            $('#statusValue').val(newStatus);

            // Update status badge
            updateStatusBadge(newStatus);

            Swal.fire({
                title: 'Updating...',
                text: 'Please wait while we update the status.',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: todoRoutes.update.replace(':id', todoId),
                method: 'POST',
                data: {
                    _method: 'PUT',
                    status: newStatus,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    Swal.close();

                    Swal.fire(
                        'Success',
                        'Status updated successfully!',
                        'success'
                    );

                    // Refresh the table
                    $('.filter-form').trigger('submit');
                },
                error: function (xhr) {
                    Swal.close();

                    // Revert to original status on error
                    $statusSpan.text(originalStatus);
                    $('#statusValue').val(originalStatus);
                    updateStatusBadge(originalStatus);

                    Swal.fire(
                        'Error!',
                        'Something went wrong. Status reverted to original.',
                        'error'
                    );
                }
            });
        }, 150);
    }

    function updateStatusBadge(status) {
        const $badge = $('#statusBadge');
        $badge.removeClass('bg-warning bg-danger bg-success').text(status);

        if (status === 'On Progress') {
            $badge.addClass('bg-warning');
        } else if (status === 'Hold') {
            $badge.addClass('bg-danger');
        } else if (status === 'Done') {
            $badge.addClass('bg-success');
        }
    }
})
</script>
@endpush

@endsection