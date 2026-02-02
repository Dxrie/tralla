{{-- 1. Create Employee Modal --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Tambah Karyawan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="createEmployeeForm">
                @csrf
                <div class="modal-body bg-light">
                    <div id="employee-fields-container">
                        <div class="card mb-3 employee-row shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="card-title text-primary m-0"><i class="bi bi-person me-1"></i> Data
                                        Karyawan</h6>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="employees[0][name]">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Alamat Email</label>
                                        <input type="email" class="form-control" name="employees[0][email]">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Password Sementara</label>
                                        <input type="password" class="form-control" name="employees[0][password]">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Divisi</label>
                                        <select class="form-select" name="employees[0][division_id]">
                                            <option value="">-</option>
                                            @foreach ($divisions as $div)
                                                <option value="{{ $div->id }}">{{ $div->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Role</label>
                                        <select class="form-select" name="employees[0][role]">
                                            <option value="employee" selected>Employee</option>
                                            <option value="employer">Employer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-outline-primary dashed-border w-100" id="add-more-btn">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Baris Karyawan Lain
                        </button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-save">Simpan Semua Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 2. Hidden Row Template (For JS) --}}
<div id="employee-row-template" class="d-none">
    <div class="card mb-3 employee-row shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="card-title text-primary m-0"><i class="bi bi-person me-1"></i> Data Karyawan</h6>
                <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="employees[INDEX][name]">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" name="employees[INDEX][email]">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Password Sementara</label>
                    <input type="password" class="form-control" name="employees[INDEX][password]">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Divisi</label>
                    <select class="form-select" name="employees[INDEX][division_id]">
                        <option value="">-</option>
                        @foreach ($divisions as $div)
                            <option value="{{ $div->id }}">{{ $div->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <select class="form-select" name="employees[INDEX][role]">
                        <option value="employee" selected>Employee</option>
                        <option value="employer">Employer</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3. Edit Employee Modal --}}
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editEmployeeForm">
                @csrf
                @method('PUT') <input type="hidden" id="edit_id" name="id">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Divisi</label>
                        <select class="form-select" id="edit_division_id" name="division_id">
                            <option value="">-</option>
                            @foreach ($divisions as $div)
                                <option value="{{ $div->id }}">{{ $div->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" id="edit_role" name="role">
                            <option value="employee">Employee</option>
                            <option value="employer">Employer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password (Opsional)</label>
                        <input type="password" class="form-control" id="edit_password" name="password"
                            placeholder="Biarkan kosong jika tidak ingin mengganti">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-update">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
