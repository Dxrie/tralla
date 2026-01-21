@extends('layouts.app')

@section('title', 'Absensi Masuk • Tralla')

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

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Whoops!</strong> Ada masalah dengan input anda:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="w-100 h-100 d-flex flex-column gap-4">
        <div class="w-100 h-50 rounded-3 p-3 d-flex flex-column overflow-hidden">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold">Absensi Masuk</h3>

                <button id="openModalBtn" type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm"
                    data-bs-toggle="modal" data-bs-target="#attendanceModal">
                    <i class="bi bi-plus-lg"></i>
                    <span>Tambah Absensi</span>
                </button>

                <x-absensi-camera />
            </div>

            <table class="table table-hover scrollable-tbody mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 20%;">Waktu</th>
                        <th style="width: 15%;">Keterangan</th>
                        <th style="width: 10%;">Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($todaysEntries as $entry)
                        <tr>
                            <td style="width: 5%;">{{ $loop->iteration }}</td>
                            <td style="width: 20%;">{{ Auth::user()->name }}</td>

                            <td style="width: 15%;">
                                @if ($entry->status === 'ontime')
                                    <span class="badge bg-success">Hadir (On Time)</span>
                                @elseif ($entry->status === 'absent')
                                    <span class="badge bg-warning text-dark">Izin (Absen)</span>
                                @else
                                    <span class="badge bg-danger">Terlambat</span>
                                @endif
                            </td>

                            {{-- Display Date (e.g., 21 January 2026) --}}
                            <td style="width: 15%;">{{ $entry->created_at->format('d F Y') }}</td>

                            {{-- Display Time (e.g., 08:30:00) --}}
                            <td style="width: 20%;">{{ $entry->created_at->format('H:i:s') }}</td>

                            <td class="text-truncate" style="width: 15%;">{{ $entry->detail }}</td>

                            <td style="width: 10%;">
                                @if ($entry->image_path)
                                    {{-- Link to view the proof in a new tab --}}
                                    <a href="{{ Storage::url($entry->image_path) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-muted small">Tidak ada foto</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada data absensi untuk hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            $(document).ready(function() {
                const $video = $('#video');
                const $canvas = $('#canvas');
                const $result = $('#result');
                const $snapBtn = $('#snapBtn');
                const $retakeBtn = $('#retakeBtn');
                const $submitBtn = $('#submitBtn');
                const $imageInput = $('#image_base64');
                const $cameraContainer = $('#camera-container');
                const $loadingText = $('#camera-loading');
                const $statusSelect = $('#statusSelect');
                const $keteranganField = $('#keterangan_field');
                const $keteranganInput = $('#keterangan');
                const $cameraWrapper = $('#camera');
                let stream = null;

                async function startCamera() {
                    try {
                        if (!stream) {
                            stream = await navigator.mediaDevices.getUserMedia({
                                video: {
                                    facingMode: "user"
                                }
                            });
                            $video[0].srcObject = stream;
                            $loadingText.addClass('d-none');
                        }
                    } catch (err) {
                        console.error("Camera Error:", err);
                        alert("Could not start camera.");
                    }
                }

                function stopCamera() {
                    if (stream) {
                        stream.getTracks().forEach(track => track.stop());
                        $video[0].srcObject = null;
                        stream = null;
                    }
                }

                function resetCameraUI() {
                    $result.addClass('d-none');
                    $cameraContainer.removeClass('d-none');
                    $imageInput.val('');

                    $snapBtn.removeClass('d-none');
                    $retakeBtn.addClass('d-none');
                    $submitBtn.prop('disabled', true);
                    $loadingText.removeClass('d-none');
                }

                $('#attendanceModal').on('shown.bs.modal', function() {
                    if ($statusSelect.val() !== 'izin') {
                        startCamera();
                    }
                });

                $('#attendanceModal').on('hidden.bs.modal', function() {
                    stopCamera();
                    resetCameraUI();
                    $statusSelect.val($statusSelect.find("option:first").val());
                    $keteranganField.addClass('d-none');
                    $cameraWrapper.removeClass('d-none');
                });

                $statusSelect.on('change', function() {
                    const value = $(this).val();

                    if (value === 'izin') {
                        $keteranganField.removeClass('d-none');
                        $keteranganInput.prop('required', true);

                        $cameraWrapper.addClass('d-none');

                        stopCamera();
                        $imageInput.val('');
                        $imageInput.prop('required', false);
                        $submitBtn.prop('disabled', false);
                    } else {
                        $keteranganField.addClass('d-none');
                        $keteranganInput.prop('required', false).val('');

                        $cameraWrapper.removeClass('d-none');

                        startCamera();
                        $imageInput.prop('required', true);

                        if ($imageInput.val() === '') {
                            $submitBtn.prop('disabled', true);
                        }
                    }
                });

                $snapBtn.on('click', function() {
                    const videoEl = $video[0];
                    const canvasEl = $canvas[0];

                    canvasEl.width = videoEl.videoWidth;
                    canvasEl.height = videoEl.videoHeight;

                    const context = canvasEl.getContext('2d');
                    context.drawImage(videoEl, 0, 0, canvasEl.width, canvasEl.height);

                    const dataUrl = canvasEl.toDataURL('image/jpeg', 0.8);

                    $result.attr('src', dataUrl).removeClass('d-none');
                    $cameraContainer.addClass('d-none');
                    $imageInput.val(dataUrl);

                    $snapBtn.addClass('d-none');
                    $retakeBtn.removeClass('d-none');
                    $submitBtn.prop('disabled', false);
                });

                $retakeBtn.on('click', function() {
                    resetCameraUI();
                });
            });
        </script>
    @endpush
@endsection
