<nav {{ $attributes->merge(['class' => 'navbar navbar-expand-md navbar-light bg-white border-bottom shadow-sm bg-light']) }}
    style="height: 70px;">
    <div class="container-fluid px-4 h-100">
        <!-- Website Logo -->
        <a class="navbar-brand d-flex align-items-center h-100" href="{{ $homeRoute() }}">
            <span class="fw-bold fs-4 text-dark">
                {{ config('app.name', 'MyApp') }}
            </span>
        </a>

        <!-- Navigation Items -->
        <div class="h-100">
            <ul class="navbar-nav d-flex flex-row gap-3 h-100 align-items-center">
                @if ($isAuthenticated)
                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown h-100">
                        <a class="nav-link dropdown-toggle text-dark h-100 d-flex align-items-center px-3 dropdown-toggle-no-arrow"
                            href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <!-- Profile Image Container -->
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="position-relative" style="width: 37px; height: 37px;">
                                    <img draggable="false"
                                        src="{{ $user->avatar
                                ? asset('storage/' . $user->avatar)
                                : asset('images/default-avatar.png') }}"
                                        class="w-100 h-100 object-fit-cover rounded-circle p-1 bg-primary bg-opacity-25"
                                        alt="{{ $user->name ?? 'User' }}">
                                </div>
                                <span class="mx-2">{{ $user->name ?? 'User' }}</span>
                                <i class="bi bi-chevron-down bi-bold"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.index') }}">
                                    <i class="bi bi-person me-2"></i>Profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item h-100">
                        <a class="nav-link text-dark h-100 d-flex align-items-center" href="{{ route('register') }}"
                            title="Register">
                            <button class="btn btn-outline-secondary px-4 rounded-pill fw-semibold">
                                Register
                            </button>
                        </a>
                    </li>
                    <li class="nav-item h-100">
                        <a class="nav-link text-dark h-100 d-flex align-items-center" href="{{ route('login') }}"
                            title="Login">
                            <button class="btn btn-primary px-4 rounded-pill fw-semibold">
                                Login
                            </button>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
