<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="staticBackdropLabel">Tambah Peminjaman Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Modal Body --}}
                <div class="modal-body">
                    {{-- Error Message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger py-2" style="font-size:0.75rem">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- Form --}}
                    <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data" id="peminjamanForm" style="font-size:0.75rem">
                        @csrf
                        {{-- Barang & Foto --}}
                        <div class="mb-3 border rounded-2 p-3">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-7">
                                    <label class="form-label fw-semibold">Name</label>
                                    <input type="text" name="nama_barang" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold">Picture</label>
                                    <input type="file" name="foto_barang" class="form-control form-control-sm" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        {{-- Divisi --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Division</label>
                            <select name="divisi" class="form-select form-select-sm" required>
                                <option value="">-- Choose Division --</option>
                                <option value="KP">KP</option>
                                <option value="MBKM">MBKM</option>
                                <option value="Manajemen">Manajemen</option>
                                <option value="Magang PKL">Magang PKL</option>
                            </select>
                        </div>
                    </form>
                </div>
                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" form="peminjamanForm">Save</button>
                </div>
            </div>
        </div>
    </div>