@extends('layouts.auth')

@section('title', 'Login • Tralla')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <!-- Card -->
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <!-- Card Header -->
                    <div class="card-header bg-white border-0 pb-0 mt-1">
                        <div class="text-center py-2">
                            <!-- Title -->
                            <h1 class="h3 fw-bold mb-2">Welcome Back</h1>
                            <p class="text-muted mb-0">Sign in to your account to continue</p>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-3 p-md-4">
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf

                            <!-- Email Input -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>

                            <!-- Password Input -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control @error('email') is-invalid @enderror"
                                        id="password" name="password" required>
                                    <button class="btn btn-light border" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label text-muted" for="remember">
                                        Remember me
                                    </label>
                                </div>
                                <a href="" class="text-decoration-none">
                                    Forgot password?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-md fw-medium py-2">
                                    <span class="spinner-border spinner-border-sm d-none" id="loginSpinner"></span>
                                    Sign In
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center pt-4 border-top">
                                <p class="text-muted mb-0">
                                    Don't have an account?
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-medium">
                                        Sign up
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            $(function() {
                $('button[type="submit"]').prop('disabled', false)
                $('#loginSpinner').addClass('d-none')

                $('#togglePassword').on('click', function() {
                    const passwordInput = $('#password');
                    const icon = $(this).find('i');

                    const isPassword = passwordInput.attr('type') === 'password';
                    passwordInput.attr('type', isPassword ? 'text' : 'password');

                    icon.toggleClass('bi-eye bi-eye-slash');
                });

                $('form').on('submit', function () {
                    const $btn = $(this).find('button[type="submit"]')

                    $btn.prop('disabled', true)
                    $btn.find('#loginSpinner').removeClass('d-none')
                })

                setTimeout(function() {
                    $('.alert').fadeOut(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            });
        </script>
    @endpush
@endsection
