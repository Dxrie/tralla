@extends('layouts.app')

@section('title', 'Log Aktivitas • Tralla')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h4 text-gray-800">Log Aktivitas Karyawan</h2>
            </div>
        </div>

        <div class="card shadow border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu</th>
                                <th>Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td style="width: 200px;">
                                        <i class="bi bi-clock me-2 text-muted"></i>
                                        {{ $log['timestamp'] }}
                                    </td>
                                    <td>
                                        {{ $log['message'] }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-5 text-muted">
                                        <i class="bi bi-clipboard-data fs-1 d-block mb-2"></i>
                                        Tidak ada log aktivitas ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
