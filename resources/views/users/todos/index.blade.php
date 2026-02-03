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
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="fw-bold text-center mb-0">To-Do List</h3>
        <button id='openModalBtn' type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#todoModal">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah To-Do</span>
        </button>
    </div>
    <div class="d-flex flex-column gap-2">
        <div>
            <form action="{{ route('todo.index') }}" method="GET" class="d-flex gap-2 w-100 filter-form">
                @csrf
                <select name="status" class="form-select form-select-sm" style="width: 20%; font-size:0.925rem">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
        
                <select name="bulan" class="form-select form-select-sm" style="width: 20%; font-size:0.925rem">
                    <option value="">Semua Bulan</option>
                    @foreach ($months as $num => $name)
                        <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
        
                <select name="tahun" class="form-select form-select-sm" style="width: 20%; font-size:0.925rem">
                    <option value="">Semua Tahun</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
        
                <button type="submit" class="btn btn-primary btn-sm" id="filterButton" style="font-size:0.925rem">
                    <i class="spinner-border spinner-border-sm d-none" id="filterSpinner"></i>
                    <span>Filter</span>
                </button>
                <a href="{{ route('todo.index') }}" class="btn btn-outline-secondary btn-sm" id="filterResetBtn" style="font-size:0.925rem">
                    Reset
                </a>
            </form>
        </div>
        <div class="w-100 rounded-2 bg-white p-3">
            <div class="table-responsive">
                <table class="table table-hover mb-4" style="font-size:0.925rem;">
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
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="todoModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow rounded-3">
            <div class="modal-header">
                <h5 class="modal-title" id="todoModalTitle">New To-Do</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="todoForm">
                @csrf

                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="todo_id" id="todoId">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text"
                            name="title"
                            class="form-control form-control-sm"
                            value="{{ old('title') }}"
                           >
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subtasks</label>
                        <div id="subtasksWrapper">
                        </div>

                        <button type="button" id="addSubtaskBtn" class="btn btn-primary btn-sm mt-2">
                            <i class="bi bi-plus-lg"></i> Add Subtask
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <input type="text"
                            name="description"
                            class="form-control form-control-sm"
                            value="{{ old('description') }}"
                           >
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="to-do" {{ old('status') == 'to-do' ? 'selected' : '' }}>To-Do</option>
                            <option value="on progress" {{ old('status') == 'on progress' ? 'selected' : '' }}>On Progress</option>
                            <option value="hold" {{ old('status') == 'hold' ? 'selected' : '' }}>Hold</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Starting Date</label>
                        <input type="date"
                            name="start_date"
                            class="form-control form-control-sm"
                            value="{{ old('start_date', date('Y-m-d')) }}"
                           >
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Finish Date</label>
                        <input type="date"
                            name="finish_date"
                            class="form-control form-control-sm"
                            value="{{ old('finish_date', date('Y-m-d')) }}"
                           >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger buttons" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="spinner-border spinner-border-sm d-none" id="submitSpinner"></i>
                        <span id="submitBtnText">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
table {
    width: 100%;
    max-width: 100%;
}

.modal-dialog-scrollable .modal-body {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}

.no-visual-btn {
  background-color: transparent;
  border: none;
  padding: 0;
  margin: 0;
  cursor: pointer;
  outline: none;
  box-shadow: none;
}

.description-cell {
    display: block;
    max-width: 100%;
    overflow: hidden;

    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;

    word-break: break-word;
    white-space: normal;
    line-height: 1.4;
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
    })

    // =====================
    // FORM SUBMIT (AJAX)
    // =====================
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

                if (res.html) {
                    // Remove empty row if exists
                    $('tbody tr:contains("Belum ada data")').remove();

                    if ($('#todoId').val()) {
                        // Update existing row
                        $(`#subtasks-${res.id}`).closest('tr').remove();
                        $(`#todoTableBody tr[data-id="${res.id}"]`).replaceWith(res.html);
                    } else {
                        // Prepend new row
                        $('#todoTableBody').prepend(res.html);
                    }
                }
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

    $('.filter-form').on('submit', function (e) {
        $('#filterBtn').prop('disabled', true)
        $('#filterResetBtn').prop('disabled', true)
        $('#filterBtn').find('#filterSpinner').removeClass('d-none')
    });

    $('#openModalBtn').on('click', function () {
        $('#todoForm')[0].reset();
        $('#subtasksWrapper').empty();

        $('#todoForm').attr('action', '{{ route("todo.store") }}');
        $('#formMethod').val('POST');
        $('#todoId').val('');

        $('#todoModalTitle').text('New To-Do');
        $('#submitBtnText').text('Simpan');
    });

    $('tbody').on('click', '.editTodoBtn', function () {
        const data = $(this).data();

        $('#todoForm').attr('action', todoRoutes.update.replace(':id', data.id));
        $('#formMethod').val('PUT');
        $('#todoId').val(data.id);

        $('input[name="title"]').val(data.title);
        $('input[name="description"]').val(data.description);
        $('select[name="status"]').val(data.status);
        $('input[name="start_date"]').val(data.start_date);
        $('input[name="finish_date"]').val(data.finish_date);

        const $wrapper = $('#subtasksWrapper');
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
                $.ajax({
                    url: todoRoutes.destroy.replace(':id', todoId),
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        $row.remove();
                        $(`#subtasks-${res.id}`).closest('tr').remove();

                        // If no rows left, add empty row
                        if ($('tbody tr').length === 0) {
                            $('tbody').append(`
                                <tr class="text-center">
                                    <td colspan="7">Belum ada data</td>
                                </tr>
                            `);
                        }

                        Swal.fire(
                            'Deleted!',
                            'Your todo has been deleted.',
                            'success'
                        );
                    },
                    error: function (xhr) {
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

    // TOGGLE SUBTASK (AJAX)
    $('tbody').on('change', '.subtask-checkbox', function () {
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
            },
            error: function (xhr) {
                // Close loading Swal
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
})
</script>
@endpush

@endsection

