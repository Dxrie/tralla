@extends('layouts.app')

@section('title', $user->firstName() . ' • Tralla')

@section('content')
<div class="row gap-4 gap-lg-0">
    <div class="col-lg-5">
        <div class="d-flex flex-column p-3 bg-light rounded-3 shadow">
            <p class="fs-4 fw-semibold text-light bg-primary flex-grow-1 text-center py-3 rounded-2 mb-4">Profile Picture</p>
            <div class="d-flex flex-column gap-3">
                <form action="{{ route('profile.avatar') }}"
                method="POST"
                enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="file"
                    id="changeavatar"
                    name="avatar"
                    class="form-control d-none @error('avatar') is-invalid @enderror"
                    accept=".jpg,.jpeg,.png">

                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center gap-2">
                            <span class="btn btn-primary flex-grow-1" onclick="$('#changeavatar').click()">
                                Change Avatar
                            </span>
                            <button type="button" id="confirmAvatar" class="btn btn-success d-none" title="Confirm">
                                <i class="bi bi-check-lg"></i>
                            </button>
                            <button type="button" id="cancelAvatar" class="btn btn-danger d-none" title="Cancel">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                </form>
                
                <button type="button" id="deleteAvatar" class="btn btn-danger flex-grow-1 @if (!$user->avatar) d-none @endif" title="Delete">Delete Avatar</button>

                {{-- Avatar Preview --}}
                <div class="text-center">
                    <img
                        src="{{ $user->avatar
                                ? asset('storage/' . $user->avatar)
                                : asset('images/default-avatar.png') }}"
                        class="img-fluid rounded-2 my-2 shadow"
                        style="max-height: 300px; object-fit: cover;"
                        alt="Profile Avatar"
                        id="avatarPreview">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="d-flex flex-column p-3 bg-light rounded-3 shadow">
            <p class="fs-4 fw-semibold text-light bg-primary flex-grow-1 text-center py-3 rounded-2 mb-4">{{ $user->firstName() }}'s Credentials</p>
            <form id="profile-form" class="d-flex flex-column gap-1 mb-4" action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="d-flex flex-row gap-2 align-items-center">
                    <label for="name" style="width: 30%" class="fw-medium">Name</label>
                    <input type="text" style="width: 70%" class="form-control-p bg-light @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ $user->name }}" readonly>
                </div>
                <div class="d-flex flex-row gap-2 align-items-center">
                    <label for="email" style="width: 30%" class="fw-medium">Email</label>
                    <input type="email" style="width: 70%" class="form-control-p bg-light @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ $user->email }}" readonly>
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
                    <i class="bi bi-pen-fill me-2"></i>Edit
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
                <i class="bi bi-key-fill me-2"></i>Change Password
            </button>
        </div>  
    </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow rounded-3">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('profile.change-password') }}" method="POST" id="change-password-form">
                @csrf
                @method('PUT')
                <div class="modal-body d-flex flex-column gap-3">
                    <div>
                        <label class="fw-medium mb-1">Old Password</label>
                        <input type="password" class="form-control @error('old_password') is-invalid @enderror" value="{{ old('old_password') }}" name="old_password">
                        @error('old_password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div>
                        <label class="fw-medium mb-1">New Password</label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password">
                        @error('new_password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div>
                        <label class="fw-medium mb-1">Confirm Password</label>
                        <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation">
                        @error('new_password_confirmation')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" id="changePassCancelBtn" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="changePassBtn">
                        <span class="spinner-border spinner-border-sm d-none" id="changePassSpinner"></span>
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
}

.form-control-p:disabled,
.form-control-p[readonly] {
    color: black;
    border-bottom: none;
    cursor: default;
    outline: none;
}

.form-control-p:not(:disabled):not([readonly]):not(p),
.form-control-p.is-invalid:not(:disabled):not([readonly]):not(p) {
    outline: none;
    font-size: 0.925rem;
    border-bottom: 2px solid #0d6efd;
}

.form-control-p.is-invalid:not(:disabled):not([readonly]):not(p) {
    outline: none;
    font-size: 0.925rem;
    border-bottom: 2px solid #dc3545 !important;
}
</style>

<script type="module">
$(document).ready(function () {

    const $form      = $('#profile-form');
    const $inputs    = $form.find('input');
    const $editBtn   = $('#editBtn');
    const $cancelBtn = $('#cancelBtn');

    let isEditing = false;
    const originalValues = {};

    // Save original values
    $inputs.each(function () {
        originalValues[this.name] = $(this).val();
    });

    $inputs.on('input change', function () {
        const $input = $(this);
        const name   = $input.attr('name');
        const value  = $input.val().trim();

        let isValid = true;

        if (name === 'name') {
            isValid = value.length >= 3;
        }

        if (name === 'email') {
            isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
        }

        $input.toggleClass('is-invalid', !isValid);
    })

    // =========================
    // EDIT / SAVE BUTTON
    // =========================
    $editBtn.on('click', function () {

        if (!isEditing) {
            $inputs.prop('readonly', false);

            $editBtn
                .html('<span class="spinner-border spinner-border-sm d-none me-2" id="editSpinner"></span><i class="bi bi-check me-2"></i>Save')
                .removeClass('btn-primary')
                .addClass('btn-success');

            $cancelBtn.removeClass('d-none');
            isEditing = true;
            return;
        }

        $editBtn
            .prop('disabled', true)
            .find('#editSpinner').removeClass('d-none')
            .end()
            .find('i').addClass('d-none')
        $cancelBtn.prop('disabled', true)

        // =========================
        // AJAX SUBMIT
        // =========================
        $.ajax({
            url: $form.attr('action'),
            type: 'PUT',
            data: $form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (res) {
                // Update original values
                Object.keys(res.user).forEach(key => {
                    originalValues[key] = res.user[key];
                });

                // Lock inputs
                $inputs.prop('readonly', true);

                // Reset UI
                $editBtn
                    .html('<i class="bi bi-pen-fill me-2"></i>Edit')
                    .removeClass('btn-success')
                    .addClass('btn-primary')
                    .prop('disabled', false)
                    .find('#editSpinner').removeClass('d-none')

                $cancelBtn
                    .addClass('d-none')
                    .prop('disabled', false)

                isEditing = false;

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message,
                    confirmButtonText: 'OK'
                });
            },

            error: function (xhr) {
                const errors = xhr.responseJSON?.errors || {};

                // Clear old errors
                $inputs.removeClass('is-invalid');

                // Show validation errors
                Object.keys(errors).forEach(field => {
                    $(`[name="${field}"]`).addClass('is-invalid');
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please fix the errors.',
                    confirmButtonText: 'OK'
                });

                $editBtn
                    .prop('disabled', false)
                    .find('#editSpinner').addClass('d-none')
                    .end()
                    .find('i').removeClass('d-none')
                $cancelBtn.prop('disabled', false)
            }
        });
    });

    // =========================
    // CANCEL BUTTON
    // =========================
    $cancelBtn.on('click', function () {
        $inputs.each(function () {
            $(this).val(originalValues[this.name]).prop('readonly', true);
        });

        $inputs.removeClass('is-invalid')

        $editBtn
            .html('<i class="bi bi-pen-fill me-2"></i>Edit')
            .removeClass('btn-success')
            .addClass('btn-primary');

        $cancelBtn.addClass('d-none');
        isEditing = false;
    });

    $('#changePassCancelBtn').prop('disabled', false)
    $('#changePassBtn').prop('disabled', false)
    $('#changePassSpinner').addClass('d-none')

    $('#change-password-form').on('submit', function() {
        const $btn = $('#changePassBtn')

        $('#changePassCancelBtn').prop('disabled', true)
        $btn.prop('disabled', true)
        $btn.find('#changePassSpinner').removeClass('d-none')
    })

    @if ($errors->has('old_password') ||
    $errors->has('new_password') ||
    $errors->has('new_password_confirmation'))
        $("#changePasswordBtn").click();
    @endif

    let selectedFile = null;
    const originalSrc = '{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}';

    // Function to crop image to 1:1 aspect ratio
    function cropToSquare(dataURL) {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const size = Math.min(img.width, img.height);
                canvas.width = size;
                canvas.height = size;
                const offsetX = (img.width - size) / 2;
                const offsetY = (img.height - size) / 2;
                ctx.drawImage(img, offsetX, offsetY, size, size, 0, 0, size, size);
                resolve(canvas.toDataURL('image/jpeg'));
            };
            img.src = dataURL;
        });
    }

    // Handle avatar change
    $('#changeavatar').on('change', function() {
        const file = this.files[0];
        if (file) {
            selectedFile = file;
            // Show preview
            const reader = new FileReader();
            reader.onload = async function(e) {
                const croppedDataURL = await cropToSquare(e.target.result);
                $('#avatarPreview').attr('src', croppedDataURL);
            };
            reader.readAsDataURL(file);
            // Show buttons
            $('#confirmAvatar, #cancelAvatar').removeClass('d-none');
        }
    });

    // Confirm avatar
    $('#confirmAvatar').on('click', function() {
        if (selectedFile) {
            const formData = new FormData();
            formData.append('avatar', selectedFile);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('_method', 'PUT');

            Swal.fire({
                title: 'Updating...',
                text: 'Please wait while we update your profile.',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route("profile.avatar") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.close();

                    // Update to the uploaded image
                    $('img[alt="Profile Avatar"]').attr('src', res.avatar_url);
                    selectedFile = null;
                    $('#confirmAvatar, #cancelAvatar').addClass('d-none');
                    // Show delete button
                    $('#deleteAvatar').removeClass('d-none');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr) {
                    Swal.close();
                    
                    // Revert preview
                    $('img[alt="Profile Avatar"]').attr('src', originalSrc);
                    selectedFile = null;
                    $('#confirmAvatar, #cancelAvatar').addClass('d-none');
                    const errorMessage = xhr.responseJSON?.message || 'Failed to update avatar.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });

    // Cancel avatar
    $('#cancelAvatar').on('click', function() {
        // Revert preview
        $('img[alt="Profile Avatar"]').attr('src', originalSrc);
        selectedFile = null;
        $('#confirmAvatar, #cancelAvatar').addClass('d-none');
        // Clear file input
        $('#changeavatar').val('');
    });

    // Delete avatar
    $('#deleteAvatar').on('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to delete your profile picture?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait while we delete your profile picture.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '{{ route("profile.avatar.delete") }}',
                    type: 'PATCH',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                success: function(res) {
                    Swal.close();

                    // Update avatar to default
                    $('#avatarPreview').attr('src', res.avatar_url);
                    $('img[alt="Profile Avatar"]').attr('src', res.avatar_url);
                    // Hide delete button
                    $('#deleteAvatar').addClass('d-none');

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: res.message,
                        confirmButtonText: 'OK'
                    });
                },
                    error: function(xhr) {
                        Swal.close();
                        const errorMessage = xhr.responseJSON?.message || 'Failed to delete avatar.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    })
});
</script>
@endsection