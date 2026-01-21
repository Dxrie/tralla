@extends('layouts.app')

@section('content')
    <style>
        .scrollable-tbody tbody {
            display: block;
            flex-grow: 1;
            overflow-y: scroll;
            width: 100%;
        }

        .scrollable-tbody thead,
        .scrollable-tbody tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        *::-webkit-scrollbar {
            display: none;
        }

        * {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        #customPopup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
    </style>

    <div class="w-100 h-100 d-flex flex-column gap-4">
        <div class="w-100 h-50 rounded-3 border p-3 d-flex flex-column overflow-hidden">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Absensi Masuk</h3>

                <button id="openModalBtn" type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm"
                    data-bs-toggle="modal" data-bs-target="#attendanceModal">
                    <i class="bi bi-plus-lg"></i>
                    <span>Tambah Absensi</span>
                </button>

                <div class="modal fade" id="attendanceModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">New Entry</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-hover scrollable-tbody mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 10%;">No</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 20%;">Keterangan</th>
                        <th style="width: 20%;">Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 1; $i++)
                        <tr>
                            <td style="width: 10%;">{{ $i }}</td>
                            <td style="width: 20%;">Ahmad</td>
                            <td style="width: 15%;"><span class="badge bg-success">Hadir</span></td>
                            <td style="width: 15%;">25 Agustus 2025</td>
                            <td style="width: 20%;">Tidak ada keterangan</td>
                            <td style="width: 20%;">Bukti Disini woi</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            $('#openModalBtn').on('click', function() {
                $('#attendanceModal').modal('show');
            });

            $('#openBtn').on('click', function() {
                $('#customPopup').fadeIn();
            });

            $('#closeBtn').on('click', function() {
                $('#customPopup').fadeOut();
            });

            if ($('#customPopup').is(':visible')) {
                console.log("The popup is currently open");
            }
        </script>
    @endpush
@endsection
