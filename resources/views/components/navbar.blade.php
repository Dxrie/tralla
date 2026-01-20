{{-- Needs to be redone --}}
<nav {{ $attributes->merge(['class' => 'navbar navbar-expand-md navbar-light bg-white border-bottom shadow-sm']) }}>
    <div class="container-fluid px-4">
        <!-- Website Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            @if(config('app.logo_url'))
                <img 
                    src="{{ config('app.logo_url') }}" 
                    alt="{{ config('app.name') }} Logo"
                    class="d-inline-block align-text-top"
                    height="30"
                >
            @else
                <span class="fw-bold fs-4 text-dark">
                    {{ config('app.name', 'MyApp') }}
                </span>
            @endif
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- About Us -->
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('about') }}" title="About Us">
                        About
                    </a>
                </li>

                <!-- Home Icon -->
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ $homeRoute() }}" 
                       title="{{ $isAuthenticated ? 'Dashboard' : 'Home' }}">
                        <i class="bi bi-house-door"></i>
                    </a>
                </li>

                @if($isAuthenticated)
                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" 
                           id="navbarDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i>Edit Profile
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
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('login') }}" title="Login">
                            Login
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>