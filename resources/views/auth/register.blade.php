@extends('layouts.auth')

@section('title', 'Register • Tralla')

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
                            <h1 class="h3 fw-bold mb-2">Hello There</h1>
                            <p class="text-muted mb-0">Register your account to continue</p>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-3 p-md-4">
                        <form method="POST" action="{{ route('register.post') }}">
                            @csrf

                            <!-- Username Input -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-medium">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required autofocus>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

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
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
                                    <button class="btn btn-light border" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="ToS" id="ToS">
                                    <label class="form-check-label text-muted" for="ToS">
                                        I have read and agreed with the <a href="" class="">Terms &
                                            Services</a>.
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-md fw-medium py-2">
                                    Register
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center pt-4 border-top">
                                <p class="text-muted mb-0">
                                    Already have an account?
                                    <a href="{{ route('login') }}" class="text-decoration-none fw-medium">
                                        Login
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
                $('#togglePassword').on('click', function() {
                    const passwordInput = $('#password');
                    const icon = $(this).find('i');

                    const isPassword = passwordInput.attr('type') === 'password';
                    passwordInput.attr('type', isPassword ? 'text' : 'password');

                    icon.toggleClass('bi-eye bi-eye-slash');
                });

                setTimeout(function() {
                    $('.alert').fadeOut(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            });
        </script>
    @endpush

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .input-group-text {
            transition: all 0.3s ease;
        }

        .form-control:focus+.input-group-text {
            border-color: #667eea;
        }

        #togglePassword:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection

