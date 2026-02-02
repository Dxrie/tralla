<div class="d-flex flex-column flex-shrink-0 py-4 px-2 bg-light h-100" style="width: 280px;">
    <a href="{{ route('profile.index') }}" class="text-decoration-none">
        <div class="d-flex justify-content-center align-items-center flex-column mb-2">
            <div class="position-relative" style="width: 56px; height: 56px;">
                <img draggable="false"
                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                    class="w-100 h-100 object-fit-cover rounded-circle border" alt="{{ $user->name ?? 'User' }}">
            </div>
            <span class="mt-2 px-2 fw-medium text-dark">{{ $user->name ?? 'User' }}</span>
            <p class="px-2 text-muted small"><span class="text-capitalize">{{ $user->role ?? 'Employee' }}</span> of
                PT. Tralla</p>
        </div>
    </a>

    <!-- Scrollable menu container -->
    <div class="sidebar-scroll-container flex-grow-1" style="overflow-y: auto; overflow-x: hidden;">
        <ul class="nav nav-pills flex-column mb-auto">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'link-dark' }} d-flex align-items-center"
                    aria-current="page">
                    <i class="bi bi-house-fill me-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Karyawan -->
            <li class="nav-item">
                <a href="{{ route('karyawan.index') }}"
                    class="nav-link {{ request()->routeIs('karyawan.index') ? 'active' : 'link-dark' }} d-flex align-items-center">
                    <i class="bi bi-person-fill me-3"></i>
                    <span>Karyawan</span>
                </a>
            </li>

            <!-- Absensi Dropdown -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('absensi.*') ? 'active' : 'link-dark' }} d-flex align-items-center justify-content-between"
                    data-bs-toggle="collapse" href="#absensiCollapse" role="button"
                    aria-expanded="{{ request()->routeIs('absensi.*') ? 'true' : 'false' }}"
                    aria-controls="absensiCollapse">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-check-fill me-3"></i>
                        <span>Absensi</span>
                    </div>
                    <i class="bi bi-chevron-right collapse-chevron"></i>
                </a>

                <div class="collapse" id="absensiCollapse">
                    <ul class="nav flex-column ps-4">
                        <li class="nav-item">
                            <a href="{{ route('absensi.masuk') }}"
                                class="nav-link {{ request()->routeIs('absensi.masuk') ? 'active' : 'link-dark' }} d-flex align-items-center py-2">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                <span>Absen Masuk</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('absensi.keluar') }}"
                                class="nav-link {{ request()->routeIs('absensi.keluar') ? 'active' : 'link-dark' }} d-flex align-items-center py-2">
                                <i class="bi bi-clock-fill me-2"></i>
                                <span>Absen Keluar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Izin -->
            <li class="nav-item">
                <a href="{{ route('izin.index') }}"
                    class="nav-link {{ request()->routeIs('izin.index') ? 'active' : 'link-dark' }} d-flex align-items-center">
                    <i class="bi bi-calendar-x-fill me-3"></i>
                    <span>Izin</span>
                </a>
            </li>

            <!-- Peminjaman Barang -->
            <li class="nav-item">
                <a href="{{ route('peminjaman.index') }}"
                    class="nav-link {{ request()->routeIs('peminjaman.index') ? 'active' : 'link-dark' }} d-flex align-items-center">
                    <i class="bi bi-box-seam-fill me-3"></i>
                    <span>Peminjaman Barang</span>
                </a>
            </li>
        </ul>
    </div>
</div>
