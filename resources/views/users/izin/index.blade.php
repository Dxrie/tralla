@extends('layouts.app')

@section('title', 'Data Izin • Tralla')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Form --}}
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label mb-1">Search nama</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari nama karyawan...">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label mb-1">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                        <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label mb-1">Dari</label>
                    <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label mb-1">Sampai</label>
                    <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label mb-1">Per halaman</label>
                    <select name="per_page" class="form-select">
                        @foreach ([10, 25, 50, 100] as $pp)
                            <option value="{{ $pp }}" @selected((int) request('per_page', 10) === $pp)>{{ $pp }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Terapkan
                    </button>
                    <a href="{{ route('izin.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="w-100 rounded-2 bg-white p-3">
        <div class="table-responsive">
            <table class="table table-hover scrollable-tbody mb-0" style="font-size: 0.925rem">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%;">No</th>
                        <th class="text-start" style="width: 20%;">Nama Karyawan</th>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 10%;">Waktu</th>
                        <th class="text-start" style="width: 25%;">Keterangan</th>
                        <th style="width: 15%;">Status</th>
                        @if (auth()->user()?->role === 'employer')
                            <th class="text-end" style="width: 10%;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($absents as $activity)
                        <tr class="text-center" id="izin-row-{{ $activity->id }}" data-absent-id="{{ $activity->id }}"
                            data-approve-url="{{ route('izin.approve', $activity) }}"
                            data-reject-url="{{ route('izin.reject', $activity) }}">
                            <td>{{ ($absents->firstItem() ?? 0) + $loop->index }}</td>
                            <td class="text-start">{{ $activity->user->name }}</td>

                            <td>{{ $activity->created_at->format('d F Y') }}</td>
                            <td>{{ $activity->created_at->format('H:i') }}</td>

                            <td class="text-muted text-start">
                                <div class="truncate-cell" title="{{ $activity->detail ?: '-' }}">
                                    {{ $activity->detail ?: '-' }}
                                </div>
                            </td>

                            <td class="izin-status-cell">
                                @if ($activity->status === 'approved')
                                    <span class="badge bg-success text-light">Approved</span>
                                @elseif ($activity->status === 'pending')
                                    <span class="badge bg-warning text-light">Waiting for approval</span>
                                @else
                                    <span class="badge bg-danger text-light">Rejected</span>
                                @endif
                            </td>

                            @if (auth()->user()?->role === 'employer')
                                <td class="text-end izin-actions-cell">
                                    @if ($activity->status === 'pending')
                                        <button type="button" class="btn btn-sm btn-success btn-izin-action" title="Setujui"
                                            data-url="{{ route('izin.approve', $activity) }}" data-action="approve">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger btn-izin-action" title="Tolak"
                                            data-url="{{ route('izin.reject', $activity) }}" data-action="reject"
                                            data-confirm="Yakin menolak izin ini?">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    @elseif ($activity->status === 'approved')
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-izin-action"
                                            title="Batalkan / Tolak" data-url="{{ route('izin.reject', $activity) }}" data-action="reject"
                                            data-confirm="Batalkan persetujuan dan tolak izin ini?">
                                            <i class="bi bi-x-lg me-1"></i>Tolak
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-outline-success btn-izin-action"
                                            title="Setujui" data-url="{{ route('izin.approve', $activity) }}" data-action="approve">
                                            <i class="bi bi-check-lg me-1"></i>Setujui
                                        </button>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()?->role === 'employer' ? 7 : 6 }}" class="text-center text-muted py-5">
                                <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                                Belum ada data izin karyawan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $absents->appends(request()->query())->links() }}
        </div>
    </div>

<style>
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
@endsection

@push('scripts')
    <script type="module">
        $(function() {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            function getStatusBadge(status) {
                const badges = {
                    approved: '<span class="badge bg-success text-light">Approved</span>',
                    pending: '<span class="badge bg-warning text-light">Waiting for approval</span>',
                    rejected: '<span class="badge bg-danger text-light">Rejected</span>'
                };
                return badges[status] || badges.pending;
            }

            function getActionsHtml(status, approveUrl, rejectUrl) {
                if (status === 'pending') {
                    return '<button type="button" class="btn btn-sm btn-success btn-izin-action" title="Setujui" data-url="' + approveUrl + '" data-action="approve"><i class="bi bi-check-lg"></i></button> ' +
                        '<button type="button" class="btn btn-sm btn-danger btn-izin-action" title="Tolak" data-url="' + rejectUrl + '" data-action="reject" data-confirm="Yakin menolak izin ini?"><i class="bi bi-x-lg"></i></button>';
                }
                if (status === 'approved') {
                    return '<button type="button" class="btn btn-sm btn-outline-danger btn-izin-action" title="Batalkan / Tolak" data-url="' + rejectUrl + '" data-action="reject" data-confirm="Batalkan persetujuan dan tolak izin ini?"><i class="bi bi-x-lg me-1"></i>Tolak</button>';
                }
                return '<button type="button" class="btn btn-sm btn-outline-success btn-izin-action" title="Setujui" data-url="' + approveUrl + '" data-action="approve"><i class="bi bi-check-lg me-1"></i>Setujui</button>';
            }

            $(document).on('click', '.btn-izin-action', function() {
                const btn = $(this);
                const url = btn.data('url');
                const confirmMsg = btn.data('confirm');
                const row = btn.closest('tr');
                const approveUrl = row.data('approve-url');
                const rejectUrl = row.data('reject-url');

                function sendRequest() {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: { _token: csrf, _method: 'PATCH' },
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    }).done(function(res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 2000, showConfirmButton: false });
                        row.find('.izin-status-cell').html(getStatusBadge(res.status));
                        row.find('.izin-actions-cell').html(getActionsHtml(res.status, approveUrl, rejectUrl));
                    }).fail(function(xhr) {
                        const text = (xhr.responseJSON && xhr.responseJSON.message) || xhr.statusText || 'Terjadi kesalahan.';
                        Swal.fire({ icon: 'error', title: 'Gagal', text: text });
                    });
                }

                if (confirmMsg) {
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: confirmMsg,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#0d6efd',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal'
                    }).then(function(result) {
                        if (result.isConfirmed) sendRequest();
                    });
                } else {
                    sendRequest();
                }
            });
        });
    </script>
@endpush
