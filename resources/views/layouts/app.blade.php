<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <x-navbar />

    <main class="d-flex flex-grow-1 overflow-hidden">
        {{-- Desktop Sidebar --}}
        <aside class="sidebar d-none d-md-flex">
            <x-sidebar />
        </aside>

        {{-- Mobile Offcanvas Sidebar --}}
        <div
            class="offcanvas offcanvas-start d-md-none"
            tabindex="-1"
            id="sidebarOffcanvas"
            aria-labelledby="sidebarOffcanvasLabel"
            style="width: 280px;"
        >
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">
                    {{ config('app.name', 'Tralla') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body p-0">
                <x-sidebar />
            </div>
        </div>

        {{-- Main Content --}}
        <div
            class="flex-grow-1 p-4 bg-secondary bg-opacity-25"
            style="overflow-y:auto; overflow-x:hidden; min-width:0;"
        >
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </main>

    @stack('scripts')
    @if (session('success'))
    <script type="module">
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            timer: 2500,
            showConfirmButton: false
        });
    </script>
    @endif
    @if (session('error'))
    <script type="module">
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error') }}",
            timer: 2500,
            showConfirmButton: false
        });
    </script>
    @endif
</body>

</html>
