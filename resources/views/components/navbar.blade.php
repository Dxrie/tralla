<nav {{ $attributes->merge(['class' => 'navbar navbar-expand-md navbar-light bg-white border-bottom shadow-sm bg-light']) }} style="height: 70px;">
    <div class="container-fluid px-4 h-100">
        <!-- Website Logo -->
        <a class="navbar-brand d-flex align-items-center h-100" href="{{ $homeRoute() }}">
            <span class="fw-bold fs-4 text-dark">
                {{ config('app.name', 'MyApp') }}
            </span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler h-100 py-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Items -->
        <div class="collapse navbar-collapse h-100" id="navbarNav">
            <ul class="navbar-nav ms-auto h-100 align-items-center">
                @if(!$isAuthenticated)
                <!-- About Us -->
                <li class="nav-item h-100">
                    <a class="nav-link text-dark h-100 d-flex align-items-center px-3" href="{{ route('about') }}" title="About Us">
                        About Us
                    </a>
                </li>

                <!-- Home Icon -->
                <li class="nav-item h-100">
                    <a class="nav-link text-dark h-100 d-flex align-items-center px-3" href="{{ $homeRoute() }}">
                        Home
                    </a>
                </li>
                @endif

                @if($isAuthenticated)
                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown h-100">
                        <a class="nav-link dropdown-toggle text-dark h-100 d-flex align-items-center px-3 dropdown-toggle-no-arrow" href="#" 
                           id="navbarDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- Profile Image Container -->
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="position-relative" style="width: 37px; height: 37px;">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR1Ge5ZNd1jtWQIUJVaZhczOC8H1JNSlg443g&s" 
                                         class="w-100 h-100 object-fit-cover rounded-circle p-1 bg-primary bg-opacity-25"
                                         alt="{{ $user->name ?? 'User' }}">
                                </div>
                                <span class="mx-2">{{ $user->name ?? 'User' }}</span>
                                <i class="bi bi-chevron-down bi-bold"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bi bi-person me-2"></i>Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
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
                    <!-- Login link -->
                    <li class="nav-item h-100">
                        <a class="nav-link text-dark h-100 d-flex align-items-center px-3" href="{{ route('login') }}" title="Login">
                            Login
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>