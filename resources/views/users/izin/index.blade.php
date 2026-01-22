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

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
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
                            <td>{{ $loop->iteration }}</td>
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
@endsection
