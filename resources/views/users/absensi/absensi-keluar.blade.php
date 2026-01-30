@extends('layouts.app')

@section('title', 'Absensi Keluar • Tralla')

@section('content')
    <style>
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
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="fw-bold">Absensi Pulang</h3>

            <button id="openModalBtn" type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm"
                data-bs-toggle="modal" data-bs-target="#attendanceModal">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Absensi</span>
            </button>

            <x-absensi-camera />
        </div>

        <div class="w-100 rounded-2 bg-white p-3">
            <table class="table table-hover mb-0" style="font-size: 0.925rem">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 25%;">Tanggal</th>
                        <th style="width: 20%;">Waktu</th>
                        <th style="width: 25%;">Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($todaysEntries as $entry)
                        <tr>
                            <td style="width: 5%;">{{ $loop->iteration }}</td>
                            <td style="width: 20%;">{{ $entry->user->name }}</td>

                            {{-- Display Date (e.g., 21 January 2026) --}}
                            <td style="width: 25%;">{{ $entry->created_at->format('d F Y') }}</td>

                            {{-- Display Time (e.g., 08:30:00) --}}
                            <td style="width: 20%;">{{ $entry->created_at->format('H:i:s') }}</td>

                            <td style="width: 25%;">
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
                                <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
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
            $(document).ready(() => {
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

                const $video = $('#video');
                const $canvas = $('#canvas');
                const $result = $('#result');
                const $snapBtn = $('#snapBtn');
                const $retakeBtn = $('#retakeBtn');
                const $submitBtn = $('#submitBtn');
                const $imageInput = $('#image_base64');
                const $cameraContainer = $('#camera-container');
                const $loadingText = $('#camera-loading');

                let stream = null;

                $('#attendanceModal').on('shown.bs.modal', async function() {
                    try {
                        stream = await navigator.mediaDevices.getUserMedia({
                            video: {
                                facingMode: "user"
                            }
                        });

                        $video[0].srcObject = stream;
                        $loadingText.addClass('d-none');
                    } catch (err) {
                        alert("Camera access denied or not available!");
                        console.error(err);
                    }
                });

                $('#attendanceModal').on('hidden.bs.modal', function() {
                    if (stream) {
                        stream.getTracks().forEach(track => track.stop());
                        $video[0].srcObject = null;
                    }
                    resetCamera();
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
                    resetCamera();
                });

                function resetCamera() {
                    $result.addClass('d-none');
                    $cameraContainer.removeClass('d-none');
                    $imageInput.val('');

                    $snapBtn.removeClass('d-none');
                    $retakeBtn.addClass('d-none');
                    $submitBtn.prop('disabled', true);
                    $loadingText.removeClass('d-none');
                }
            });
        </script>
    @endpush
@endsection
