@extends('layouts.app')

@section('title', 'Tralla - Peminjaman Barang')

@section('content')
<div class="w-100 h-100 d-flex flex-column gap-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-center mb-0">Peminjaman Barang</h3>
        <button id='openModalBtn' type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#formModal">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Peminjaman</span>
        </button>
    </div>

    {{-- Filter --}}
    <div class="w-100 rounded-2 bg-white p-3">
        <form method="GET" class="filter-form row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <label class="form-label mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Cari title peminjaman...">
            </div>

            <div class="col-6 col-md-2">
                <label class="form-label mb-1">Divisi</label>
                <select name="division" class="form-select">
                    <option value="">Semua</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->name }}" {{ request('division') == $division->name ? 'selected' : '' }}>
                            {{ $division->name }}
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
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;" class="text-start">Title</th>
                        <th style="width: 20%;" class="text-start">Description</th>
                        <th style="width: 15%;">Division</th>
                        <th style="width: 15%;">Date of Loan</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody id="loanTableBody">
                    @forelse ($loans as $index => $loan)
                        @include('users.loans.partials.table-row', ['loan' => $loan, 'index' => $index + 1])
                    @empty
                        <tr class="text-center">
                            <td colspan="6">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3" id="paginationContainer">
                {{ $loans->appends(request()->query())->links() }}
        </div>
    </div>
</div>

{{-- Form Modal --}}
@include('users.loans.partials.form-modal')

{{-- View Modal --}}
@include('users.loans.partials.view-modal')

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
const loanRoutes = {
    store: '{{ route("loan.store") }}',
    update: '{{ route("loan.update", ":id") }}',
    destroy: '{{ route("loan.destroy", ":id") }}'
};

$(function () {
    const $form      = $('#loanForm');
    const $inputs    = $form.find('input:not([name="_method"]), select, textarea');
    const $submitBtn = $form.find('button[type="submit"]');
    const $buttons   = $form.find('button[type="button"]:not(.btn-close)');
    const $spinner   = $('#submitSpinner');
    const $wrapper   = $('#itemsWrapper');
    const $addBtn    = $('#addItemBtn');

    $addBtn.on('click', function () {
        $wrapper.append(`
            <div class="d-flex flex-row mb-2 item-row gap-2">
                <input type="text" name="items[]" id="create_item" class="form-control form-control-sm">
                <button type="button" class="btn btn-outline-danger btn-sm remove-item"><i class="bi bi-trash"></i></button>
            </div>
        `);

        $wrapper.parent()[0].scrollTop = $wrapper.parent()[0].scrollHeight;
    });

    $wrapper.on('click', '.remove-item', function () {
        $(this).closest('.item-row').remove();
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

        // Add one initial item input
        $wrapper.append(`
            <div class="d-flex flex-row mb-2 item-row gap-2">
                <input type="text" name="items[]" id="create_item" class="form-control form-control-sm" required>
                <button type="button" class="btn btn-outline-danger btn-sm remove-item"><i class="bi bi-trash"></i></button>
            </div>
        `);

        $form.attr('action', '{{ route("loan.store") }}');
        $('#formMethod').val('POST');
        $('#loanId').val('');

        $('#formModalTitle').text('Create New Loan');
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

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.message,
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'Something went wrong.',
                        'error'
                    );
                }

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

        $('#filterBtn').prop('disabled', true);
        $('#filterResetBtn').prop('disabled', true);
        $('#filterBtn').find('#filterSpinner').removeClass('d-none');

        $.ajax({
            url: '{{ route("loan.index") }}',
            method: 'GET',
            data: $(this).serialize() + '&ajax=1',
            success: function (res) {
                $('#loanTableBody').html(res.html);
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
                $('#loanTableBody').html(res.html);
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

    // OPEN EDIT MODE FORM
    $('tbody').on('click', '.editLoanBtn', function () {
        const data = $(this).data();

        $form.attr('action', loanRoutes.update.replace(':id', data.id));
        $('#formMethod').val('PUT');
        $('#loanId').val(data.id);

        $('#loanForm input[name="title"]').val(data.title);
        $('#loanForm input[name="description"]').val(data.description);
        $('#loanForm select[name="division_id"]').val(data.division_id);
        $('#loanForm input[name="date"]').val(data.date);

        $wrapper.empty();

        if (data.items && data.items.length > 0) {
            data.items.forEach(name => {
                $wrapper.append(`
                    <div class="item-row d-flex flex-row mb-2 gap-2">
                        <input type="text" name="items[]" class="form-control form-control-sm" value="${name}" required>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-item"><i class="bi bi-trash"></i></button>
                    </div>
                `);
            });
        } else {
            // Add one initial item if no items exist
            $wrapper.append(`
                <div class="d-flex flex-row mb-2 item-row gap-2">
                    <input type="text" name="items[]" id="create_item" class="form-control form-control-sm" required>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-item"><i class="bi bi-trash"></i></button>
                </div>
            `);
        }

        $('#formModalTitle').text('Edit To-Do');
        $('#submitBtnText').text('Update');
    });

    $('tbody').on('click', '.deleteLoanBtn', function () {
        const loanId = $(this).data('id');
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
                    text: 'Please wait while we delete the todo.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: loanRoutes.destroy.replace(':id', loanId),
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        Swal.close();

                        Swal.fire(
                            'Deleted!',
                            'Your Loan has been deleted.',
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

    // VIEW LOAN MODAL
    $('tbody').on('click', '.viewLoanBtn', function () {
        const data = $(this).data();

        $('#viewTitle').text(data.title);
        $('#viewDescription').text(data.description || '-');
        $('#viewDate').text(data.date);
        $('#viewDivision').text(data.division);

        // Items
        const $itemsContainer = $('#viewItems');
        $itemsContainer.empty();
        if (data.items && data.items.length > 0) {
            data.items.forEach((name, index) => {
                $itemsContainer.append(`
                    <div class="d-flex align-items-center gap-3 mb-2 p-2 rounded-2 border">
                        <span class="badge bg-primary rounded-pill">${index + 1}</span>
                        <span class="fw-medium">${name}</span>
                    </div>
                `);
            });
        } else {
            $itemsContainer.append(`
                <div class="text-center py-4">
                    <i class="bi bi-inbox-fill text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">No items found</p>
                </div>
            `);
        }
    });
});
</script>
@endpush

@endsection