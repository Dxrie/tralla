@extends('layouts.app')

@section('title', $user->firstName() . ' • Tralla')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="d-flex flex-column p-3 bg-light rounded-3 shadow">
            <p class="fs-4 fw-semibold text-light bg-primary flex-grow-1 text-center py-3 rounded-2 mb-4">Profile Picture</p>
        </div>
    </div>
    <div class="col-md-7">
        <div class="d-flex flex-column p-3 bg-light rounded-3 shadow">
            <p class="fs-4 fw-semibold text-light bg-primary flex-grow-1 text-center py-3 rounded-2 mb-4">{{ $user->firstName() }}'s Credentials</p>
            <form id="profile-form" class="d-flex flex-column gap-1 mb-4" action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="d-flex flex-row gap-2 align-items-center">
                    <label for="name" style="width: 30%" class="fw-medium">Name</label>
                    <input type="text" style="width: 70%" class="form-control-p bg-light @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ $user->name }}" disabled>
                </div>
                <div class="d-flex flex-row gap-2 align-items-center">
                    <label for="email" style="width: 30%" class="fw-medium">Email</label>
                    <input type="email" style="width: 70%" class="form-control-p bg-light @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ $user->email }}" disabled>
                </div>
                <div class="d-flex flex-row gap-2 align-items-center">
                    <label for="role" style="width: 30%" class="fw-medium">Role</label>
                    <p style="width: 70%" class="text-capitalize form-control-p bg-light m-0">{{ $user->role }}</p>
                </div>
                <div class="d-flex flex-row gap-2 align-items-center">
                    <label for="role" style="width: 30%" class="fw-medium">Date as Employee</label>
                    <p style="width: 70%" class="text-capitalize form-control-p bg-light m-0">{{ $user->created_at?->format("d F Y") ?? "-" }}</p>
                </div>
            </form>

            <div class="mt-2 d-flex justify-content-between align-items-center">
            <div>
                <button type="submit" form="profile-form" id="submitBtn" class="d-none"></button>
                <button type="button"
                        id="editBtn"
                        class="btn btn-primary px-3">
                    <i class="bi bi-pen me-2"></i>Edit
                </button>

                <button type="button"
                        id="cancelBtn"
                        class="btn btn-danger px-3 d-none">
                    Cancel
                </button>
            </div>

            <button type="button"
                    id="changePasswordBtn"
                    class="btn btn-secondary px-3"
                    data-bs-toggle="modal"
                    data-bs-target="#changePasswordModal">
                <i class="bi bi-key me-2"></i>Change Password
            </button>
        </div>  
    </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow rounded-3">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="change-password-form">
                <div class="modal-body d-flex flex-column gap-3">

                    <div>
                        <label class="fw-medium mb-1">Old Password</label>
                        <input type="password" class="form-control" name="old_password">
                    </div>

                    <div>
                        <label class="fw-medium mb-1">New Password</label>
                        <input type="password" class="form-control" name="new_password">
                    </div>

                    <div>
                        <label class="fw-medium mb-1">Confirm Password</label>
                        <input type="password" class="form-control" name="new_password_confirmation">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-control-p {
    width: 100%;
    background-color: transparent;
    border: none;
    border-radius: 0;
    padding: 0.4rem 0.2rem;
    font-size: 1rem;
    transition: all 0.2s ease;

    &:disabled {
        color: black;
    }
}

.form-control-p:not(:disabled):not(p), .form-control-p.is-invalid:not(:disabled):not(p)  {
    outline: none;
    font-size: 0.925rem;
    border-bottom: 2px solid #0d6efd;
}
</style>

<script type="module">
$(document).ready(function () {
    // ==============================
    // ELEMENT SELECTORS
    // ==============================
    const $editBtn   = $('#editBtn');
    const $cancelBtn = $('#cancelBtn');
    const $submitBtn = $('#submitBtn');
    const $form      = $('#profile-form');
    const $inputs    = $form.find('input');

    // ==============================
    // STORE ORIGINAL VALUES
    // ==============================
    const originalValues = {};

    $inputs.each(function () {
        const name  = $(this).attr('name');
        const value = $(this).val();

        originalValues[name] = value;
    });

    // ==============================
    // EDIT MODE STATE
    // ==============================
    let isEditing = false;

    // ==============================
    // EDIT / SAVE BUTTON HANDLER
    // ==============================
    $editBtn.on('click', function () {

        // ==========================
        // ENTER EDIT MODE
        // ==========================
        if (!isEditing) {

            // Enable all inputs
            $inputs.prop('disabled', false);

            // Change Edit button → Save
            $editBtn
                .html('<i class="bi bi-check me-2"></i>Save')
                .removeClass('btn-primary')
                .addClass('btn-success');

            // Show Cancel button
            $cancelBtn.removeClass('d-none');

            // Update state
            isEditing = true;

        } 
        // ==========================
        // SAVE MODE
        // ==========================
        else {

            // Trigger form submit
            $submitBtn.trigger('click');
        }
    });

    // ==============================
    // CANCEL BUTTON HANDLER
    // ==============================
    $cancelBtn.on('click', function () {

        // Restore original values & disable inputs
        $inputs.each(function () {
            const name = $(this).attr('name');
            $(this)
                .val(originalValues[name])
                .prop('disabled', true);
        });

        // Restore Edit button appearance
        $editBtn
            .html('<i class="bi bi-pen me-2"></i>Edit')
            .removeClass('btn-success')
            .addClass('btn-primary');

        // Hide Cancel button
        $cancelBtn.addClass('d-none');

        // Reset state
        isEditing = false;
    });
});
</script>
@endsection