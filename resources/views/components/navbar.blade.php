<nav {{ $attributes->merge(['class' => 'bg-white shadow-sm border-b']) }}>
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-14">
            <!-- Left: Website Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    {{-- Use your logo here --}}
                    @if(config('app.logo_url'))
                        <img 
                            src="{{ config('app.logo_url') }}" 
                            alt="{{ config('app.name') }} Logo"
                            class="h-8 w-auto"
                        >
                    @else
                        <span class="text-xl font-bold text-gray-900">
                            {{ config('app.name', 'MyApp') }}
                        </span>
                    @endif
                </a>
            </div>

            <!-- Right: Navigation Items -->
            <div class="flex items-center space-x-4">
                <!-- About Us (Always visible) -->
                <a 
                    href="{{ route('about') }}"
                    class="text-gray-600 hover:text-gray-900 transition-colors"
                    title="About Us"
                >
                    About
                </a>

                <!-- Home Icon (Different route based on auth) -->
                <a 
                    href="{{ $homeRoute() }}"
                    class="text-gray-600 hover:text-gray-900 transition-colors"
                    title="{{ $isAuthenticated ? 'Dashboard' : 'Tralla' }}"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>

                <!-- Profile (Only when authenticated) -->
                @if($isAuthenticated)
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            @click="open = !open"
                            class="flex items-center text-gray-600 hover:text-gray-900 focus:outline-none transition-colors"
                            title="Profile"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>
                        
                        <!-- Simple dropdown -->
                        <div 
                            x-show="open"
                            @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border"
                            style="display: none;"
                        >
                            <a 
                                href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                Edit Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button 
                                    type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                >
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Login link when not authenticated -->
                    <a 
                        href="{{ route('login') }}"
                        class="text-gray-600 hover:text-gray-900 transition-colors"
                        title="Login"
                    >
                        Login
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>