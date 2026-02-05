<div class="modal fade" id="formModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="formModalTitle">Tambah Peminjaman</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="loanForm">
                @csrf

                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="loan_id" id="loanId">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="create_nama_peminjam">Title</label>
                        <input type="text" name="title" class="form-control form-control-sm" id="create_nama_peminjam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="create_keterangan">Description</label>
                        <input type="text" name="description" class="form-control form-control-sm" id="create_keterangan">
                    </div>
                    <div class="mb-3">
                        <label for="create_nama_barang" class="form-label fw-semibold">Item Name</label>
                        <div id="itemsWrapper"></div>
                        <button type="button" id="addItemBtn" class="btn btn-outline-primary btn-sm" style="border-style: dashed; width: 100%;;">
                            <i class="bi bi-plus-lg"></i>Add Item
                        </button>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="date">Date of Loan</label>
                        <input type="date" name="date" class="form-control form-control-sm" id="create_tanggal_pinjam" required>
                    </div>
                    <div class="mb-3">
                        <label for="create-divisi" class="form-label fw-semibold">Division</label>
                        <select name="division_id" id="create_divisi" class="form-select form-select-sm" required>
                            @if($userDivision)
                                <option value="{{ $userDivision->id }}" selected>{{ $userDivision->name }}</option>
                            @else
                                <option value="" disabled selected>Pilih Divisi</option>
                            @endif
                            @foreach($divisions as $division)
                                @if(!$userDivision || $userDivision->id != $division->id)
                                    <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger buttons" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="spinner-border spinner-border-sm d-none" id="submitSpinner"></i>
                        <span id="submitBtnText">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>