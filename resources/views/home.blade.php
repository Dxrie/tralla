@extends('layouts.home')

@section('title', 'Tralla - Sistem Absensi Modern')

@section('content')

    {{-- 1. HERO SECTION --}}
    <section class="d-flex align-items-center position-relative overflow-hidden"
        style="min-height: 85vh; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="row align-items-center g-5">
                {{-- Left Text --}}
                <div class="col-lg-6 text-center text-lg-start z-1">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3 fw-bold">
                        🚀 Solusi Absensi Digital No. #1
                    </span>
                    <h1 class="display-3 fw-bold mb-4 lh-sm text-dark">
                        Kelola Kehadiran <br>
                        <span class="text-primary">Lebih Efisien.</span>
                    </h1>
                    <p class="lead text-secondary mb-5 pe-lg-5">
                        Tralla membantu perusahaan memantau kehadiran, izin, dan produktivitas karyawan secara realtime,
                        akurat, dan anti-curang.
                    </p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                        <a href="{{ route('login') }}"
                            class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm transition-hover">
                            Masuk Sekarang <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        {{-- Jika ada route register --}}
                        {{-- <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4 py-3 rounded-pill fw-bold">Daftar</a> --}}
                    </div>

                    {{-- Small Trust Indicators --}}
                    <div
                        class="mt-5 pt-3 d-flex align-items-center justify-content-center justify-content-lg-start gap-4 opacity-75">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-shield-check fs-4 text-success"></i>
                            <span class="small fw-semibold">Data Aman</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-lightning-charge fs-4 text-warning"></i>
                            <span class="small fw-semibold">Realtime</span>
                        </div>
                    </div>
                </div>

                {{-- Right Illustration / Abstract Shape --}}
                <div class="col-lg-6 position-relative">
                    {{-- Decorative Blobs --}}
                    <div class="position-absolute top-50 start-50 translate-middle bg-primary opacity-10 rounded-circle"
                        style="width: 500px; height: 500px; filter: blur(80px); z-index: 0;"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. FEATURES SECTION --}}
    <section class="py-5 bg-white" id="features">
        <div class="container py-5">
            <div class="text-center mb-5" style="max-width: 700px; margin: 0 auto;">
                <h6 class="text-primary fw-bold text-uppercase letter-spacing-2">Kenapa Tralla?</h6>
                <h2 class="fw-bold display-6">Fitur Canggih untuk <br>Kebutuhan Perusahaan Anda</h2>
            </div>

            <div class="row g-4">
                {{-- Feature 1 --}}
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                        <div class="card-body text-center">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-person-bounding-box fs-2"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Absensi Wajah</h4>
                            <p class="text-muted mb-0">
                                Validasi kehadiran menggunakan foto selfie realtime untuk mencegah kecurangan dan titip
                                absen.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Feature 2 --}}
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                        <div class="card-body text-center">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-clock-history fs-2"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Laporan Realtime</h4>
                            <p class="text-muted mb-0">
                                Pantau data kehadiran, keterlambatan, dan izin karyawan detik itu juga dari dashboard admin.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Feature 3 --}}
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                        <div class="card-body text-center">
                            <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info rounded-circle mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-phone fs-2"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Mobile Friendly</h4>
                            <p class="text-muted mb-0">
                                Akses mudah dari smartphone apa saja tanpa perlu install aplikasi berat. Cukup via browser.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. CTA BOTTOM --}}
    <section class="py-5 bg-dark text-white text-center">
        <div class="container py-4">
            <h2 class="fw-bold mb-3">Siap Meningkatkan Produktivitas?</h2>
            <p class="text-white-50 mb-4 fs-5">Bergabunglah dengan Tralla dan digitalkan sistem absensi Anda hari ini.</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary">
                Mulai Sekarang
            </a>
        </div>
    </section>

    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .075) !important;
        }

        .floating-anim {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translatey(0px);
            }

            50% {
                transform: translatey(-20px);
            }

            100% {
                transform: translatey(0px);
            }
        }

        .letter-spacing-2 {
            letter-spacing: 2px;
        }
    </style>
@endsection
