@if ($isAuthenticated)
<div class="d-flex flex-column flex-shrink-0 py-4 px-2 bg-light h-100" style="width: 280px;">
    <a href="{{ route('profile.index') }}" class="text-decoration-none">
        <div class="d-flex justify-content-center align-items-center flex-column mb-2">
            <div class="position-relative" style="width: 56px; height: 56px;">
                <img draggable="false"
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR1Ge5ZNd1jtWQIUJVaZhczOC8H1JNSlg443g&s"
                    class="w-100 h-100 object-fit-cover rounded-circle border" alt="{{ $user->name ?? 'User' }}">
            </div>
            <span class="mt-2 px-2 fw-medium text-dark">{{ $user->name ?? 'User' }}</span>
            <p class="px-2 text-muted small"><span class="text-capitalize">{{ $user->role ?? 'Employee' }}</span> of PT.
                Tralla</p>
        </div>
    </a>

    <!-- Scrollable menu container -->
    <div class="sidebar-scroll-container flex-grow-1" style="overflow-y: auto; overflow-x: hidden;">
        <ul class="nav nav-pills flex-column mb-auto">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'link-dark' }} d-flex align-items-center" aria-current="page">
                    <i class="bi bi-speedometer2 me-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Absensi Dropdown -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('absensi.*') ? 'active' : 'link-dark' }} d-flex align-items-center justify-content-between" data-bs-toggle="collapse"
                    href="#absensiCollapse" role="button" aria-expanded="{{ request()->routeIs('absensi.*') ? 'true' : 'false' }}" aria-controls="absensiCollapse">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-check me-3"></i>
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
                                <i class="bi bi-clock me-2"></i>
                                <span>Absen Keluar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('absensi.keluar') }}"
                                class="nav-link {{ request()->routeIs('absensi.keluar') ? 'active' : 'link-dark' }} d-flex align-items-center py-2">
                                <i class="bi bi-clock me-2"></i>
                                <span>Absen Lembur</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Izin -->
            <li class="nav-item">
                <a href="{{ route('izin.index') }}" class="nav-link {{ request()->routeIs('izin.index') ? 'active' : 'link-dark' }} d-flex align-items-center">
                    <i class="bi bi-calendar-x me-3"></i>
                    <span>Izin</span>
                </a>
            </li>

            <!-- To Do List -->
            <li class="nav-item">
                <a href="{{ route('todo.index') }}" class="nav-link {{ request()->routeIs('todo.index') ? 'active' : 'link-dark' }} d-flex align-items-center">
                    <i class="bi bi-check-circle me-3"></i>
                    <span>To Do List</span>
                </a>
            </li>

            <!-- Peminjaman Barang -->
            <li class="nav-item">
                <a href="{{ route('peminjaman.index') }}" class="nav-link {{ request()->routeIs('peminjaman.index') ? 'active' : 'link-dark' }} d-flex align-items-center">
                    <i class="bi bi-box-seam me-3"></i>
                    <span>Peminjaman Barang</span>
                </a>
            </li>

            <!-- Laporan Dropdown -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : 'link-dark' }} d-flex align-items-center justify-content-between" data-bs-toggle="collapse"
                    href="#laporanCollapse" role="button" aria-expanded="{{ request()->routeIs('laporan.*') ? 'true' : 'false' }}" aria-controls="laporanCollapse">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-file-text me-3"></i>
                        <span>Laporan</span>
                    </div>
                    <i class="bi bi-chevron-right collapse-chevron"></i>
                </a>

                <div class="collapse" id="laporanCollapse">
                    <ul class="nav flex-column ps-4">
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ request()->routeIs('peminjaman.index') ? 'active' : 'link-dark' }} d-flex align-items-center py-2">
                                <i class="bi bi-clock me-2"></i>
                                <span>Project</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ request()->routeIs('peminjaman.index') ? 'active' : 'link-dark' }} d-flex align-items-center py-2">
                                <i class="bi bi-clock me-2"></i>
                                <span>Kehadiran</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ request()->routeIs('peminjaman.index') ? 'active' : 'link-dark' }} d-flex align-items-center py-2">
                                <i class="bi bi-clock me-2"></i>
                                <span>Keterlambatan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ request()->routeIs('peminjaman.index') ? 'active' : 'link-dark' }} d-flex align-items-center py-2">
                                <i class="bi bi-clock me-2"></i>
                                <span>Ketidakhadiran</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>

    {{-- <hr> --}}

    <!-- Fixed bottom section (outside scroll) -->
    {{-- <div class="sidebar-bottom">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="w-100">
                    @csrf
                    <button type="submit"
                        class="nav-link link-dark d-flex align-items-center w-100 border-0 bg-transparent">
                        <i class="bi bi-box-arrow-right me-3"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </li>
        </ul>
    </div> --}}
</div>
@endif