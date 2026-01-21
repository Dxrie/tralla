<div class="modal fade" id="attendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="attendanceForm"
                    action="{{ $state === 'masuk' ? route('absensi.masuk.store') : route('absensi.keluar.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ($state === 'masuk')
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option disabled selected>Pilih status absensi</option>
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                            </select>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Ambil Foto (Wajib)</label>

                        <div id="camera-container" class="w-100 bg-dark rounded overflow-hidden position-relative"
                            style="height: 250px;">
                            <video id="video" autoplay playsinline class="w-100 h-100 object-fit-cover"></video>
                            <div id="camera-loading"
                                class="position-absolute top-50 start-50 translate-middle text-white">
                                Starting Camera...
                            </div>
                        </div>

                        <img id="result" class="img-fluid rounded d-none w-100 border" style="max-height: 250px;">

                        <input type="hidden" name="image_base64" id="image_base64" required>

                        <div class="mt-2 text-center">
                            <button type="button" id="snapBtn" class="btn btn-primary btn-sm rounded-pill px-4">
                                <i class="bi bi-camera-fill me-1"></i> Ambil Foto
                            </button>
                            <button type="button" id="retakeBtn"
                                class="btn btn-secondary btn-sm rounded-pill px-4 d-none">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Ulangi
                            </button>
                        </div>
                    </div>

                    <canvas id="canvas" class="d-none"></canvas>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Simpan
                            Absensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
