@extends('layouts.app')

@section('title', 'Data Izin - Tralla')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover scrollable-tbody mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 25%;">Nama Karyawan</th>
                            <th style="width: 15%;">Status</th>
                            <th style="width: 20%;">Tanggal</th>
                            <th style="width: 10%;">Waktu</th>
                            <th style="width: 25%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absents as $activity)
                            <tr>
                                <td>{{ ($absents->firstItem() ?? 0) + $loop->index }}</td>
                                <td>{{ $activity->user->name }}</td>

                                <td>
                                    @if ($activity->status === 'approved')
                                        <span class="badge bg-success text-light">Approved</span>
                                    @elseif ($activity->status === 'pending')
                                        <span class="badge bg-warning text-light">Waiting for approval</span>
                                    @else
                                        <span class="badge bg-danger text-light">Not Approved</span>
                                    @endif
                                </td>

                                <td>{{ $activity->created_at->format('d F Y') }}</td>
                                <td>{{ $activity->created_at->format('H:i') }}</td>

                                <td class="text-muted">
                                    {{ $activity->detail ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                                    Belum ada data izin karyawan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $absents->links() }}
    </div>
@endsection
